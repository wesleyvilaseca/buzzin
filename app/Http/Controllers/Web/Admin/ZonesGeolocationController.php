<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateZones;
use App\Models\Zone;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\Request;

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
        $data['geo'] = true;
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
        $data['geo'] = true;
        $data['is_edit'] = 'N';
        $data['method'] = 'POST';
        $data['routeAction'] = route('zone.geolocation.store');


        return view('admin.zones.create', $data);
    }


    public function edit($id) {
        $zone = $this->repository->find($id);
        if (!$zone) {
            return redirect()->back()->with('error', 'Operação não autorizada');
        }

        $zone->data = json_decode($zone->data);

        $title = 'Editar zona ' . $zone->name;
        $data['title']              = $title;
        $data['toptitle']           = $title;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.zones.geolocation'), 'title' => 'Zonas de entrega por geolocalização'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => $title, 'active' => true];
        $data['zone'] = $zone;
        $data['_zone'] = true;
        $data['geo'] = true;
        $data['is_edit'] = 'S';
        $data['method'] = 'PUT';

        $polygonCoords = [];
        foreach ($zone->coordinates[0] as $coords) {
            $polygonCoords[] = (object)   ['lat' => $coords->getLat(), 'lng' => $coords->getLng()];
        }
        $data['routeAction'] = route('zone.geolocation.update', [$zone->id]);

        return view('admin.zones.create', $data);
    }

    public function search(Request $request) {
    }


    public function show($id) {
    }

    public function store(StoreUpdateZones $request) {

        if($request->delivery_time_end <= $request->delivery_time_ini){
            return response()->json(['error' => true, 'message' => 'O tempo de entra final não pode ser menor que o tempo inicial'], 400);
        }

        $coordinates = $this->makePolygon(json_decode($request->input('coordinates')));

        $zone = new Zone();
        $zone->name = $request->name;
        $zone->price = @tofloat($request->price);
        $zone->free_when = @tofloat($request->free_when);
        $zone->coordinates = $coordinates;
        $zone->data = json_encode((object) ['lat' => $request->point[0], 'lng' => $request->point[1], 'zoom' => $request->zoom]);
        $zone->delivery_time_ini = $request->delivery_time_ini;
        $zone->delivery_time_end = $request->delivery_time_end;
        $zone->active = $request->active;
        $zone->type = $request->type;
        $zone->free = @$request->free;
        $zone->time_type = $request->time_type;
        $res = $zone->save();

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

        $coordinates = $this->makePolygon(json_decode($request->input('coordinates')));
        $request->merge([
            'price' => tofloat($request->price),
            'free_when' => tofloat($request->free_when),
            'coordinates' => $coordinates,
            'data' => json_encode((object) ['lat' => $request->point[0], 'lng' => $request->point[1], 'zoom' => $request->zoom])
        ]);

        $res = $this->repository->where('id', $zone->id)->update($request->except(['_token', 'point', 'zoom']));
        if (!$res) {
            return response()->json(['message' => 'error durante o processo', 'error' => true], 400);
        }

        return response()->json(['message' => 'Coordenada salva com sucesso'], 200);
    }

    private function makePolygon($val) {
        $coordinates = $val;

        $polygon = [];
        foreach ($coordinates as $index => $coordinate) {
            if ($index == 0) {
                $lastcord = [$coordinate->lat, $coordinate->lng];
            }
            $polygon[] = new Point($coordinate->lat, $coordinate->lng);
        }

        $polygon[] = new Point($lastcord[0], $lastcord[1]);
        $coordinates = new Polygon([new LineString($polygon)]);

        return $coordinates;
    }

    public function checkCoordinate(Request $request) {
        $coordinate = new Point($request->input('latitude'), $request->input('longitude'));
        $shape = $this->repository->whereRaw("ST_Within(POINT(?,?), coordinates)", [$coordinate->getLng(), $coordinate->getLat()])->first();
        if ($shape) {
            return response()->json(['message' => 'Coordinate is within the shape']);
        } else {
            return response()->json(['message' => 'Coordinate is not within the shape']);
        }
    }


    public function destroy($id) {
    }
}
