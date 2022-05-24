<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;
use App\Http\Requests\Api\TenantRequest;
use App\Services\TableService;
use Illuminate\Http\Request;

class TablesController extends Controller
{
    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function tablesByTenant(TenantRequest $request)
    {
        $categories = $this->tableService->getTablesByUuid($request->uuid);
        return TableResource::collection($categories);
    }


    public function show(TenantRequest $request, $identify)
    {
        if (!$table = $this->tableService->getTableByUuid($identify)) {
            return response()->json(['message' => 'Table Not Found'], 404);
        }

        return new TableResource($table);
    }
}
