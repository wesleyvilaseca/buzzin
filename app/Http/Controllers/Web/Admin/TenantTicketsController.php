<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenantSites;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class TenantTicketsController extends Controller
{
    private $repository;

    public function __construct(TenantSites $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data['title']              = 'Suporte';
        $data['toptitle']           = 'Suporte';

        return view('admin.tenant-tickets.index', $data);
    }
    
}
