<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Http\Requests\StoreUpdateCategoryMarket;
use App\Models\CategoryMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoryMarketsController extends Controller {
    private $repository;

    public function __construct(
        CategoryMarket $category
    ) {
        $this->repository = $category;

        $this->middleware(['can:categoryMarkets']);
    }

    public function index() {
        $data['title']              = 'Categorias de supermecado';
        $data['toptitle']           = 'Categorias de supermecado';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Categorias de supermecado', 'active' => true];
        $data['marketCateg']        = true;
        $data['categories']         = $this->repository->latest()->paginate();

        return view('admin.categories_market.index', $data);
    }

    public function create() {
        $data['title']              = 'Nova categoria';
        $data['toptitle']           = 'Nova categoria';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.categories.market'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Nova categoria', 'active' => true];
        $data['marketCateg']               = true;

        return view('admin.categories_market.create', $data);
    }

    public function edit($id) {
        $category = $this->repository->find($id);

        if (!$category) {
            return Redirect::back()->with('warning', 'Operação não autorizada');
        }

        $data['title']              = 'Editar categoria ' . $category->name;
        $data['toptitle']           = 'Editar categoria ' . $category->name;
        $data['category']           = $category;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.categories'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar categoria ' . $category->name, 'active' => true];
        $data['marketCateg']                = true;

        return view('admin.categories_market.edit', $data);
    }

    public function show($id) {
        $category = $this->repository->find($id);
        if (!$category) {
            return Redirect::route('admin.categories')->with('warning', 'Operação não autorizada');
        }

        $data['title']              = 'Categoria ' . $category->name;
        $data['toptitle']           = 'Categoria ' . $category->name;
        $data['cateogory']          = $category;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.categories'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Categoria ' . $category->name, 'active' => true];
        $data['marketCateg']               = true;
        $data['category'] = $category;

        return view('admin.categories_market.show', $data);
    }


    public function store(StoreUpdateCategoryMarket $request) {
        $exist = $this->repository->where([
            'name' => $request->name
        ])->first();

        if ($exist) {
            return Redirect::back()->with('warning', 'Já existe uma categoria com esse nome');
        }

        $result = $this->repository->create($request->all());

        if (!$result) {
            return Redirect::back()->with('warning', 'Erro na operação');
        }

        return Redirect::route('admin.categories.market')->with('success', 'Categoria criado com sucesso');
    }

    public function update(StoreUpdateCategoryMarket $request, $id) {

        $category = $this->repository->find($id);

        if (!$category) {
            return Redirect::back()->with('warning', 'Operação não autorizada');
        }

        $result = $category->update($request->all());
        if (!$result) {
            return Redirect::back()->with('warning', 'Erro na operação');
        }
        return Redirect::route('admin.categories.market')->with('success', 'Categoria editado com sucesso');
    }

    public function destroy($id) {
        $category = $this->repository->find($id);

        if (!$category) {
            return Redirect::back()->with('warning', 'Operação não autorizada');
        }

        $result = $category->delete();
        if (!$result) {
            return Redirect::back()->with('warning', 'Erro na operação');
        }
        return Redirect::route('admin.categories.market')->with('success', 'Categoria removido com sucesso');
    }
}
