<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTable;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TableController extends Controller
{
    private $repository;

    public function __construct(Table $table)
    {
        $this->repository = $table;

        $this->middleware(['can:tables']);
    }

    public function index()
    {
        $data['title']              = 'Mesas';
        $data['toptitle']           = 'Mesas';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Mesas', 'active' => true];
        $data['tab']                = true;
        $data['tables']             = $this->repository->latest()->paginate();

        return view('admin.tables.index', $data);
    }

    public function create()
    {
        $data['title']              = 'Nova mesa';
        $data['toptitle']           = 'Nova mesa';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.tables'), 'title' => 'Proudutos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Nova mesa', 'active' => true];
        $data['tab']               = true;

        return view('admin.tables.create', $data);
    }

    public function search(Request $request)
    {
        $data['title']              = 'Mesas';
        $data['toptitle']           = 'Mesas';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Mesas', 'active' => true];;
        $data['tab']               = true;
        $data['tables']         = $this->repository->search($request->filter);
        $data['filters']            = $request->except('_token');

        return view('admin.tables.index', $data);
    }

    public function edit($id)
    {
        $table = $this->repository->find($id);
        if (!$table)
            return Redirect::route('admin.products')->with('warning', 'Operação não autorizada');

        $data['title']              = 'Editar mesa ' . $table->identify;
        $data['toptitle']           = 'Editar mesa ' . $table->identify;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.tables'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar mesa ' . $table->identify, 'active' => true];
        $data['tab']               = true;
        $data['table'] = $table;

        return view('admin.tables.edit', $data);
    }

    public function show($id)
    {
        $table = $this->repository->find($id);
        if (!$table)
            return Redirect::route('admin.products')->with('warning', 'Operação não autorizada');

        $data['title']              = 'Mesa ' . $table->identify;
        $data['toptitle']           = 'Mesa ' . $table->identify;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.tables'), 'title' => 'Categorias'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Mesa ' . $table->identify, 'active' => true];
        $data['tab']               = true;
        $data['table'] = $table;

        return view('admin.tables.show', $data);
    }


    public function store(StoreUpdateTable $request)
    {
        $exist = $this->repository->where('identify', '=', $request->identify)->first();
        if ($exist)
            return Redirect::back()->with('warning', 'Já existe uma mesa com essas credênciais');

        $this->repository->create($request->all());

        return Redirect::route('admin.tables')->with('success', 'Mesas cadastradas com sucesso');
    }

    public function update(StoreUpdateTable $request, $id)
    {
        $table = $this->repository->find($id);
        if (!$table)
            return Redirect::back()->with('error', 'Operação não autorizada');

        if ($table->identify !== $request->identify) {
            $exist = $this->repository->where('identify', '=', $request->identify)->first();
            if ($exist)
                return Redirect::back()->with('warning', 'Já existe uma mesa com essas credênciais');
        }

        $table->update($request->all());

        return Redirect::route('admin.tables')->with('success', 'Mesa atualizada com sucesso');
    }

    public function destroy($id)
    {
        if (!$table = $this->repository->find($id)) {
            return redirect()->back();
        }

        $table->delete();

        return redirect()->route('admin.tables');
    }

    public function qrcode($identify)
    {
        if (!$table = $this->repository->where('identify', $identify)->first()) {
            return redirect()->back();
        }

        $tenant = auth()->user()->tenant;
        $uri = env('APP_URL') . "/{$tenant->uuid}/{$table->uuid}";

        $data['tenant'] = $tenant;
        $data['uri'] = $uri;

        return view('admin.tables.qrcode', $data);
    }
}
