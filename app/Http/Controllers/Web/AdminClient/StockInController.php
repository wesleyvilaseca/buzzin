<?php

namespace App\Http\Controllers\Web\AdminClient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateStockIn;
use App\Models\ClientProductMarket;
use App\Models\ClientProductStockIn;
use App\Models\ProductMarket;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockInController extends Controller {

    private $repository;
    private $productClient;
    private $marketProducts;

    public function __construct(ClientProductStockIn $stokIn, ClientProductMarket $productClient, ProductMarket $marketProducts) {
        $this->repository = $stokIn;
        $this->productClient = $productClient;
        $this->marketProducts = $marketProducts;
    }

    public function index() {
        $data['title']              = 'Entrada de produtos';
        $data['toptitle']           = 'Entrada de produtos';
        $data['products']           = $this->marketProducts->get();
        $data['stockIn']            = $this->repository->where('client_id', Auth::guard('client')->user()->id)->get();
        $data['totalPrice']         = $this->repository
            ->select(DB::raw('sum(client_product_stock_ins.price * client_product_stock_ins.quantity) AS total'))
            ->where('client_id', Auth::guard('client')->user()->id)->first()->total;
        $data['stocki']          = true;
        $data['stock']           = true;

        return view('admin_client.stockin.index', $data);
    }

    public function store(StoreUpdateStockIn $request) {
        DB::beginTransaction();
        try {
            $productClientMarket = $this->productClient->where('product_market_id', $request->product_market_id)->first();
            if (!$productClientMarket) {
                //persiste ele na base do client
                $productClientMarket = $this->productClient->create([
                    'client_id' => Auth::guard('client')->user()->id,
                    'product_market_id' => $request->product_market_id,
                    'quantity' => 0

                ]);
            }

            //lança a entrada
            $stockIn = $this->repository->create([
                'client_id' => Auth::guard('client')->user()->id,
                'product_market_id' => $request->product_market_id,
                'nota' => $request->nota,
                'price' => tofloat($request->price),
                'quantity' => tofloat($request->quantity),
                'anotation' => $request->anotation
            ]);

            //atualiza o estoque do produto
            $productClientMarket->quantity += $request->quantity;
            $productClientMarket->update();

            DB::commit();
            return Redirect::route('client.dashboard')->with('success', 'Lançamento feito com sucesso');
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return Redirect::route('client.dashboard')->with('error', 'Houve um erro durante o lançamento de estoque');
        }
    }

    public function destroy(Request $request, $id) {
        $stockin = $this->repository->find($id);
        if (!$stockin) return Redirect::route('client.dashboard')->with('error', 'Operação não autorizada');
        DB::beginTransaction();
        try {
            $productClientMarket = $this->productClient->where([
                'product_market_id' => $stockin->product_market_id,
                'client_id' => Auth::guard('client')->user()->id
            ])->first();

            $productClientMarket->quantity -= $stockin->quantity;
            $productClientMarket->update();
            $stockin->delete();
            DB::commit();
            return Redirect::route('client.dashboard')->with('success', 'Lançamento removido com sucesso');
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return Redirect::route('client.dashboard')->with('error', 'Houve um erro durante a remoção do lançamento');
        }
    }
}
