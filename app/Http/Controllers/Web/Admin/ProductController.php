<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\ProductCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProduct;
use App\Models\Product;
use App\Models\StatusProductNoStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Services\FileCloudService;
use Exception;

class ProductController extends Controller
{
    private $repository;
    private $statusStoque;
    private $fileCloudService;

    public function __construct(
        Product $produtc,
        StatusProductNoStock $statusStoque,
        FileCloudService $fileCloudService
    ) {
        $this->repository = $produtc;
        $this->statusStoque = $statusStoque;
        $this->fileCloudService = $fileCloudService;

        $this->middleware(['can:products']);
    }

    public function index()
    {
        $data['title']              = 'Produtos';
        $data['toptitle']           = 'Produtos';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Produtos', 'active' => true];
        $data['prod']                = true;
        $data['products']         = $this->repository->latest()->paginate();

        return view('admin.products.index', $data);
    }

    public function create()
    {
        $data['title']              = 'Novo prouduto';
        $data['toptitle']           = 'Novo prouduto';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.products'), 'title' => 'Proudutos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Novo prouduto', 'active' => true];
        $data['prod']               = true;
        $data['statusStoque']       = $this->statusStoque->get();

        return view('admin.products.create', $data);
    }

    public function search(Request $request)
    {
        $data['title']              = 'Produtos';
        $data['toptitle']           = 'Produtos';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Produtos', 'active' => true];;
        $data['prod']               = true;
        $data['products']         = $this->repository->search($request->filter);
        $data['filters']            = $request->except('_token');

        return view('admin.products.index', $data);
    }

    public function edit($id)
    {
        $product = $this->repository->find($id);
        if (!$product)
            return Redirect::route('admin.products')->with('warning', 'Operação não autorizada');

        $data['title']              = 'Editar produto ' . $product->name;
        $data['toptitle']           = 'Editar produto ' . $product->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.products'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar produto ' . $product->name, 'active' => true];
        $data['prod']               = true;
        $data['product'] = $product;
        $data['statusStoque']       = $this->statusStoque->get();

        return view('admin.products.edit', $data);
    }


    public function show($id)
    {
        $product = $this->repository->find($id);
        if (!$product)
            return Redirect::route('admin.products')->with('warning', 'Operação não autorizada');

        $data['title']              = 'Produto ' . $product->name;
        $data['toptitle']           = 'Produto ' . $product->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.products'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Produto ' . $product->name, 'active' => true];
        $data['prod']               = true;
        $data['product'] = $product;

        return view('admin.products.show', $data);
    }

    public function store(StoreUpdateProduct $request)
    {
        $data = $request->all();

        $data['min_for_sale'] = $data['min_for_sale'] == 0 ? 1 : tofloat($data['min_for_sale']);

        $tenant = auth()->user()->tenant;

        $exist = $this->repository->where('title', '=', $request->title)->first();
        if ($exist)
            return Redirect::back()->with('warning', 'Já existe um produto com esse nome');

        if ($request->hasFile('image') && $request->image->isValid()) {
            try {
                $datafile = [
                    'name' => 'image',
                    'Mime-Type' => $request->file('image')->getmimeType(),
                    'contents' => fopen($request->file('image')->getPathname(), 'r')
                ];
                $data['image'] = $this->fileCloudService->storeFile($datafile, "public/tenants/{$tenant->uuid}/products");
            } catch (Exception $exception) {
                return Redirect::back()->with('error', $exception->getMessage());
            }
        }

        $product = $this->repository->create($data);

        return Redirect::route('admin.products')->with('success', 'Produto criado com sucesso');
    }

    public function update(StoreUpdateProduct $request, $id)
    {
        $product = $this->repository->find($id);
        if (!$product)
            return Redirect::back()->with('error', 'Operação não autorizada');

        if ($product->title !== $request->title) {
            $exist = $this->repository->where('title', '=', $request->title)->first();
            if ($exist)
                return Redirect::back()->with('warning', 'Já existe um produto com esse nome');
        }

        $data = $request->all();

        $data['min_for_sale'] = $data['min_for_sale'] == 0 ? 1 : tofloat($data['min_for_sale']);

        $tenant = auth()->user()->tenant;

        if ($request->hasFile('image') && $request->image->isValid()) {
             try {
                $this->fileCloudService->destroyFile($product->image);

                $datafile = [
                    'name' => 'image',
                    'Mime-Type' => $request->file('image')->getmimeType(),
                    'contents' => fopen($request->file('image')->getPathname(), 'r')
                ];
                $data['image'] = $this->fileCloudService->storeFile($datafile, "public/tenants/{$tenant->uuid}/products");
            } catch (Exception $exception) {
                return Redirect::back()->with('error', $exception->getMessage());
            }
        }

        $product->update($data);

        return Redirect::route('admin.products')->with('success', 'Produto editado com sucesso');
    }

    public function destroy($id)
    {
        $product = $this->repository->find($id);
        if (!$product)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $this->fileCloudService->destroyFile($product->image);

        $product->delete();

        return Redirect::route('admin.products')->with('success', 'Produto removido com sucesso');
    }
}
