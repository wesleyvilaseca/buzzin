<?php

namespace App\Http\Controllers\Web\AdminClient;

use App\Http\Controllers\Controller;
use App\Models\ClientProductMarket;
use App\Models\ClientProductStockIn;
use App\Models\ClientProductStockOut;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockOutController extends Controller {
    private $repository;
    private $productClient;
    private $clientProducts;

    public function __construct(ClientProductMarket $productClient, ClientProductStockOut $stockOut, ClientProductMarket $clientProducts) {
        $this->productClient = $productClient;
        $this->repository = $stockOut;
        $this->clientProducts = $clientProducts;
    }


    public function index() {
        $data['title']              = 'Saída de produtos';
        $data['toptitle']           = 'Saída de produtos';

        $data['clientProducts']     = $this->clientProducts->where([
            ['client_id', '=', Auth::guard('client')->user()->id],
            ['quantity', '>', 0]
        ])->orderBy('quantity', 'desc')->get();

        $data['stockOut']           = $this->repository->where('client_id', Auth::guard('client')->user()->id)->get();
        $data['stocko']             = true;
        $data['stock']             = true;

        return view('admin_client.stockout.index', $data);
    }

    public function store(Request $request) {
        $product = $this->productClient->where([
            'client_id' => Auth::guard('client')->user()->id,
            'product_market_id' => $request->product_market_id
        ])->first();

        if (!$product) return Redirect::route('client.dashboard')->with('error', 'Operação não autorizada');

        if ($request->quantity > $product->quantity) {
            return Redirect::route('client.dashboard')->with('warning', 'O valor da quantidade de saída não pode ser maior que a quantidade disponível em estoque');
        }

        DB::beginTransaction();
        try {

            $this->repository->create([
                'product_market_id' => $product->product_market_id,
                'client_id' => Auth::guard('client')->user()->id,
                'quantity' => tofloat($request->quantity),
                'anotation' => $request->anotation
            ]);

            $product->quantity -= $request->quantity;
            $product->update();
            DB::commit();
            return Redirect::route('client.dashboard')->with('success', 'Lançamento de saída feita com sucesso');
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return Redirect::route('client.dashboard')->with('error', 'Houve um erro durante o lançamento de saída');
        }
    }

    public function destroy(Request $request, $id) {
        $stockOut = $this->repository->find($id);
        if (!$stockOut) return Redirect::route('client.dashboard')->with('error', 'Operação não autorizada');
        DB::beginTransaction();
        try {
            $productClientMarket = $this->productClient->where([
                'product_market_id' => $stockOut->product_market_id,
                'client_id' => Auth::guard('client')->user()->id
            ])->first();

            $productClientMarket->quantity += $stockOut->quantity;
            $productClientMarket->update();
            $stockOut->delete();

            DB::commit();
            return Redirect::route('client.dashboard')->with('success', 'Lançamento removido com sucesso');
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return Redirect::route('client.dashboard')->with('error', 'Houve um erro durante a remoção do lançamento');
        }
    }
}
