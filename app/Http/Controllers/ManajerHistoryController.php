<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Pengadaan;
use Yajra\DataTables\Facades\DataTables;

class ManajerHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->page = 'manajer/history';
        $this->middleware('is_manajer');
        $this->data['route_new'] = 'manajer.history';
    }

    public function index()
    {
        $this->data['title'] = 'Data History';
        $this->data['subTitle'] = 'List History Data Stok';
        $this->data['page'] = 'History';

        return view('manajer/history/index', $this->data);
    }

    
}
