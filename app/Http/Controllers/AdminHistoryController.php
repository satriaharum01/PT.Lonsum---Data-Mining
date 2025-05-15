<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Pengadaan;
use Yajra\DataTables\Facades\DataTables;

class AdminHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->page = 'admin/history';
        $this->middleware('is_admin');
        $this->data['route_new'] = 'admin.history';
    }

    public function index()
    {
        $this->data['title'] = 'Data History';
        $this->data['subTitle'] = 'List History Data Stok';
        $this->data['page'] = 'History';

        return view('admin/history/index', $this->data);
    }
}
