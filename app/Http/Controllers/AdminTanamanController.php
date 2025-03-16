<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Tanaman;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class AdminTanamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

        $this->page = 'admin/tanaman';
        $this->data['title'] = 'Data Tanaman';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Tanaman';

        return view('admin/tanaman/index', $this->data);
    }

    public function new()
    {
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fieldTypes'] = (new Tanaman())->getField();
        $this->data['action'] = 'admin/tanaman/save';

        return view('admin/tanaman/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = Tanaman::find($id);
        $this->data['title'] = 'Data Tanaman';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new Tanaman())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'admin/tanaman/update/'.$rows->id;

        return view('admin/tanaman/detail', $this->data);
    }
    public function json()
    {
        $data = Tanaman::select('*')
                ->orderby('nama_tanaman', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = Tanaman::find($id);

        $fillAble = (new Tanaman())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Tanaman())->getFillable();
        Tanaman::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = Tanaman::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
