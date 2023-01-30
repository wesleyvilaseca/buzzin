<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProduct;
use App\Http\Requests\StoreUpdateProductMarket;
use App\Models\ProductMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductMarketsController extends Controller {
    private $repository;

    public function __construct(
        ProductMarket $produtc
    ) {
        $this->repository = $produtc;
        $this->middleware(['can:productsMarkets']);
    }

    public function index() {
        $data['title']              = 'Produtos de supermercado';
        $data['toptitle']           = 'Produtos de supermercado';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Produtos de supermercado', 'active' => true];
        $data['marketProd']         = true;
        $data['products']           = $this->repository->latest()->paginate();

        return view('admin.products_market.index', $data);
    }

    public function create() {
        $data['title']              = 'Novo produto';
        $data['toptitle']           = 'Novo produto';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.products.market'), 'title' => 'Proudutos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Novo produto', 'active' => true];
        $data['marketProd']         = true;
        return view('admin.products_market.create', $data);
    }

    public function edit($id) {
        $product = $this->repository->find($id);
        if (!$product) {
            return Redirect::route('admin.products.market')->with('warning', 'Operação não autorizada');
        }

        $data['title']              = 'Editar produto ' . $product->name;
        $data['toptitle']           = 'Editar produto ' . $product->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.products.market'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar produto ' . $product->name, 'active' => true];
        $data['marketProd']         = true;
        $data['product'] = $product;

        return view('admin.products_market.edit', $data);
    }

    public function show($id) {
        $product = $this->repository->find($id);
        if (!$product) {
            return Redirect::route('admin.products')->with('warning', 'Operação não autorizada');
        }


        $data['title']              = 'Produto ' . $product->name;
        $data['toptitle']           = 'Produto ' . $product->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.products.market'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Produto ' . $product->name, 'active' => true];
        $data['marketProd']         = true;
        $data['product'] = $product;

        return view('admin.products_market.show', $data);
    }

    public function store(StoreUpdateProductMarket $request) {
        $data = $request->all();
        $tenant = auth()->user()->tenant;

        $exist = $this->repository->where('title', '=', $request->title)->first();
        if ($exist) {
            return Redirect::back()->with('warning', 'Já existe um produto com esse nome');
        }

        if ($request->hasFile('image') && $request->image->isValid()) {
            $data['image'] = $request->image->store("public/tenants/{$tenant->uuid}/products_market");
        }

        $this->repository->create($data);

        return Redirect::route('admin.products.market')->with('success', 'Produto criado com sucesso');
    }

    public function update(StoreUpdateProductMarket $request, $id) {
        $product = $this->repository->find($id);
        if (!$product) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }


        if ($product->title !== $request->title) {
            $exist = $this->repository->where('title', '=', $request->title)->first();
            if ($exist)
                return Redirect::back()->with('warning', 'Já existe um produto com esse nome');
        }

        $data = $request->all();
        $tenant = auth()->user()->tenant;

        if ($request->hasFile('image') && $request->image->isValid()) {
            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }

            $data['image'] = $request->image->store("public/tenants/{$tenant->uuid}/products");
        }

        $product->update($data);
        return Redirect::route('admin.products.market')->with('success', 'Produto editado com sucesso');
    }

    public function destroy($id) {
        $product = $this->repository->find($id);
        if (!$product) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        if (Storage::exists($product->image)) {
            Storage::delete($product->image);
        }

        $product->delete();

        return Redirect::route('admin.products.market')->with('success', 'Produto removido com sucesso');
    }
}
