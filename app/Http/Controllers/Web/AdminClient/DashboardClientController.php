<?php

namespace App\Http\Controllers\Web\AdminClient;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ClientProductMarket;
use App\Models\ClientProductStockIn;
use App\Models\ClientProductStockOut;
use App\Models\Permission;
use App\Models\Plan;
use App\Models\Product;
use App\Models\ProductMarket;
use App\Models\Profile;
use App\Models\Role;
use App\Models\Table;
use App\Models\Tenant;
use App\Models\User;
use App\Supports\GrafficSupport\GrafficSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardClientController extends Controller {
    private $marketProducts;
    private $stockIn;
    private $clientProducts;
    private $stockOut;

    public function __construct(ProductMarket $marketProducts, ClientProductStockIn $stockIn, ClientProductMarket $clientProducts, ClientProductStockOut $stockOut) {
        $this->marketProducts = $marketProducts;
        $this->stockIn = $stockIn;
        $this->clientProducts = $clientProducts;
        $this->stockOut = $stockOut;
    }

    public function index() {
        $date = \Carbon\Carbon::today()->subDays(30);

        $data['title']              = 'Dashboard';
        $data['toptitle']           = 'Dashboard';

        $stockin = $this->stockIn
            ->where([
                ['client_product_stock_ins.created_at', '>=', $date]
            ])
            ->get();

        $stockout = $this->stockOut
            ->where([
                ['client_product_stock_outs.created_at', '>=', $date]
            ])
            ->get();
        $results = $stockin->merge($stockout)->sortByDesc('created_at');
        $data['movimentacoes'] = $results;

        //gráfico de estoque de produtos por categoria
        $stockGroupByCategory = $this->clientProducts
            ->select([
                'category_markets.name',
                DB::raw('sum(client_product_markets.quantity) AS quantity'),
            ])
            ->join('category_product_market', 'client_product_markets.product_market_id', '=', 'category_product_market.product_market_id')
            ->join('category_markets', 'category_product_market.category_market_id', '=', 'category_markets.id')
            ->join('product_markets', 'client_product_markets.product_market_id', '=', 'product_markets.id')
            ->where([
                ['client_product_markets.quantity', '>', 0]
            ])
            ->groupBy('category_markets.id')
            ->get();

        if (!$stockGroupByCategory->isEmpty()) {
            $graficoStockGroupByCategory = new GrafficSupport($stockGroupByCategory, 'name', 'quantity', true);
            $data['graficoStockGroupByCategory'] = $graficoStockGroupByCategory->getJson();
        }

        //gráfico de entrada de produtos nos ultimos 30 dias por categoria
        $stockinLast30DayGroupByCategory = $this->stockIn
            ->select([
                'category_markets.name',
                DB::raw('sum(client_product_stock_ins.quantity) AS quantity'),
            ])
            ->join('category_product_market', 'client_product_stock_ins.product_market_id', '=', 'category_product_market.product_market_id')
            ->join('category_markets', 'category_product_market.category_market_id', '=', 'category_markets.id')
            ->where([
                ['client_product_stock_ins.created_at', '>=', $date]
            ])
            ->groupBy('category_markets.id')
            ->get();

        if (!$stockinLast30DayGroupByCategory->isEmpty()) {
            $graficoStockInGroupByCategory = new GrafficSupport($stockinLast30DayGroupByCategory, 'name', 'quantity', true);
            $data['graficoStockInGroupByCategory'] = $graficoStockInGroupByCategory->getJson();
        }

        //gráfico de saida de produtos nos ultimos 30 dias por categoria
        $stockOutLast30DayGroupByCategory = $this->stockOut
            ->select([
                'category_markets.name',
                DB::raw('sum(client_product_stock_outs.quantity) AS quantity'),
            ])
            ->join('category_product_market', 'client_product_stock_outs.product_market_id', '=', 'category_product_market.product_market_id')
            ->join('category_markets', 'category_product_market.category_market_id', '=', 'category_markets.id')
            ->where([
                ['client_product_stock_outs.created_at', '>=', $date]
            ])
            ->groupBy('category_markets.id')
            ->get();

        if (!$stockOutLast30DayGroupByCategory->isEmpty()) {
            $graficoStockOutGroupByCategory = new GrafficSupport($stockOutLast30DayGroupByCategory, 'name', 'quantity', true);
            $data['graficoStockOutGroupByCategory'] = $graficoStockOutGroupByCategory->getJson();
        }

        //gráfico de valor total gasto de produtos nos ultimos 30 dias por categoria
        $stockinPriceLast30DayGroupByCategory = $this->stockIn
            ->select([
                'category_markets.name',
                DB::raw('sum(client_product_stock_ins.price * client_product_stock_ins.quantity) AS total'),
            ])
            ->join('category_product_market', 'client_product_stock_ins.product_market_id', '=', 'category_product_market.product_market_id')
            ->join('category_markets', 'category_product_market.category_market_id', '=', 'category_markets.id')
            ->where([
                ['client_product_stock_ins.created_at', '>=', $date]
            ])
            ->groupBy('category_markets.id')
            ->get();

        if (!$stockinPriceLast30DayGroupByCategory->isEmpty()) {
            $graficoStockInPriceGroupByCategory = new GrafficSupport($stockinPriceLast30DayGroupByCategory, 'name', 'total', true);
            $data['graficoStockInPriceGroupByCategory'] = $graficoStockInPriceGroupByCategory->getJson();
        }

        $data['products']           = $this->marketProducts->get();
        $data['clientProducts']     = $this->clientProducts->where('client_id', Auth::guard('client')->user()->id)->orderBy('quantity', 'desc')->get();
        $data['stockIn']            = $this->stockIn->where('client_id', Auth::guard('client')->user()->id)->get();
        $data['stockOut']           = $this->stockOut->where('client_id', Auth::guard('client')->user()->id)->get();
        $data['dashboard']          = true;

        return view('admin_client.dashboard.index', $data);
    }
}
