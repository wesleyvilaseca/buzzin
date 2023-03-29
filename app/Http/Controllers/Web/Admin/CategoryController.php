<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    private $repository;

    public function __construct(
        Category $category
    ) {
        $this->repository = $category;
        $this->middleware(['can:categories']);
    }

    public function index()
    {
        $data['title']              = 'Categorias';
        $data['toptitle']           = 'Categorias';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Categorias', 'active' => true];
        $data['cat']                = true;
        $data['categories']         = $this->repository->latest()->paginate();

        return view('admin.categories.index', $data);
    }

    public function create()
    {
        $data['title']              = 'Nova categoria';
        $data['toptitle']           = 'Nova categoria';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.categories'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Nova categoria', 'active' => true];
        $data['cat']               = true;

        return view('admin.categories.create', $data);
    }

    public function search(Request $request)
    {
        $data['title']              = 'Categorias';
        $data['toptitle']           = 'Categorias';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Categorias', 'active' => true];;
        $data['cat']               = true;
        $data['categories']         = $this->repository->search($request->filter);
        $data['filters']            = $request->except('_token');

        return view('admin.categories.index', $data);
    }


    public function show($id)
    {
        $category = $this->repository->find($id);
        if (!$category)
            return Redirect::route('admin.categories')->with('warning', 'Operação não autorizada');

        $data['title']              = 'Categoria ' . $category->name;
        $data['toptitle']           = 'Categoria ' . $category->name;
        $data['cateogory']          = $category;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.categories'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Categoria ' . $category->name, 'active' => true];
        $data['cat']               = true;
        $data['category'] = $category;

        return view('admin.categories.show', $data);
    }


    public function edit($id)
    {
        $category = $this->repository->find($id);

        if (!$category)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        $data['title']              = 'Editar categoria ' . $category->name;
        $data['toptitle']           = 'Editar categoria ' . $category->name;
        $data['category']           = $category;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.categories'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar categoria ' . $category->name, 'active' => true];
        $data['cat']                = true;

        return view('admin.categories.edit', $data);
    }

    public function store(StoreUpdateCategory $request)
    {
        DB::beginTransaction();
        try {
            $exist = $this->repository->where([
                'name' => $request->name
            ])->first();

            if ($exist) {
                return Redirect::back()->with('warning', 'Já existe uma categoria com esse nome');
            }

            if (!$request->hasFile('image')) {
                return Redirect::back()->with('warning', 'Selecione uma imagem para a categoria');
            }

            $data = $request->all();

            $tenant = auth()->user()->tenant;
            if ($request->hasFile('image') && $request->image->isValid()) {
                $image = $request->image->store("public/tenants/{$tenant->uuid}/category");
                $data['image'] = $image;
            }

            $result = $this->repository->create($data);

            if (!$result) {
                return Redirect::back()->with('warning', 'Erro na operação');
            }
            DB::commit();
            return Redirect::route('admin.categories')->with('success', 'Categoria criado com sucesso');
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return Redirect::back()->with('warning', 'Erro na operação');
        }
    }

    public function update(StoreUpdateCategory $request, $id)
    {
        $category = $this->repository->find($id);

        if (!$category) {
            return Redirect::back()->with('warning', 'Operação não autorizada');
        }

        if (!$category->image && !$request->hasFile('image')) {
            return Redirect::back()->with('warning', 'Selecione uma imagem para a categoria');
        }

        $data = $request->all();
        $tenant = auth()->user()->tenant;
        if ($request->hasFile('image') && $request->image->isValid()) {
            if (Storage::exists($category->image)) {
                Storage::delete($category->image);
            }

            $data['image'] = $request->image->store("public/tenants/{$tenant->uuid}/category");
        }

        $result = $category->update($data);
        if (!$result) {
            return Redirect::back()->with('warning', 'Erro na operação');
        }

        return Redirect::route('admin.categories')->with('success', 'Categoria editado com sucesso');
    }

    public function destroy($id)
    {
        $category = $this->repository->find($id);

        if (!$category)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        if (Storage::exists($category->image)) {
            Storage::delete($category->image);
        }

        $result = $category->delete();
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.categories')->with('success', 'Categoria removido com sucesso');
    }
}
