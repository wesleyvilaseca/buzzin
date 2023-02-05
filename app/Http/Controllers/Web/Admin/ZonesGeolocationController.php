<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Http\Requests\StoreUpdatePlan;
use App\Http\Requests\StoreUpdateZones;
use App\Models\Category;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ZonesGeolocationController extends Controller {
    private $repository;

    public function __construct(Zone $repository) {
        $this->middleware(['can:zones']);

        $this->repository = $repository;
    }

    public function index() {
        $data['title']              = 'Zonas de entregas';
        $data['toptitle']           = 'Zonas de entregas por geolocalização';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Zonas de entrega por geolocalização', 'active' => true];
        $data['_zone']               = true;
        $data['zones'] = $this->repository->latest()->paginate();

        return view('admin.zones.index', $data);
    }

    public function create() {
        $title = 'Nova zona de entrega';
        $data['title']              = $title;
        $data['toptitle']           = $title;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.zones.geolocation'), 'title' => 'Zonas de entrega por geolocalização', 'active' => true];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => $title, 'active' => true];
        $data['_zone']               = true;

        return view('admin.zones.create', $data);
    }


    public function edit($id) {
        $zone = $this->repository->find($id);
        if (!$zone) {
            return redirect()->back()->with('error', 'Operação não autorizada');
        }

        $title = 'Editar zona ' . $zone->name;
        $data['title']              = $title;
        $data['toptitle']           = $title;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.zones.geolocation'), 'title' => 'Zonas de entrega por geolocalização', 'active' => true];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => $title, 'active' => true];
        $data['zone'] = $zone;
        $data['_zone']               = true;
        $data['is_edit'] = true;

        return view('admin.zones.create', $data);
    }

    public function search(Request $request) {
    }


    public function show($id) {
    }

    public function store(StoreUpdateZones $request) {
        $coordinates = json_decode($request->coordinates);
        $request->merge([
            'price' => tofloat($request->price),
            'free_when' => tofloat($request->free_when),
            'coordinates' => json_encode($coordinates)
        ]);

        $res = $this->repository->create($request->all());
        if (!$res) {
            return response()->json(['message' => 'error durante o processo', 'error' => true], 400);
        }

        return response()->json(['message' => 'Coordenada salva com sucesso'], 200);
    }

    public function update(StoreUpdateZones $request, $id) {
        $zone = $this->repository->find($id);
        if (!$zone) {
            return response()->json(['message' => 'Operação não autorizada'], 400);
        }

        $coordinates = json_decode($request->coordinates);
        $request->merge([
            'price' => tofloat($request->price),
            'free_when' => tofloat($request->free_when),
            'coordinates' => json_encode($coordinates)
        ]);

        $res = $this->repository->where('id', $zone->id)->update($request->except(['_token']));
        if (!$res) {
            return response()->json(['message' => 'error durante o processo', 'error' => true], 400);
        }

        return response()->json(['message' => 'Coordenada salva com sucesso'], 200);
    }

    public function destroy($id) {
    }
}
