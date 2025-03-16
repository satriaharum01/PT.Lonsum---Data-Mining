<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Deduksi;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class AdminDeduksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

        $this->page = 'admin/deduksi';
        $this->data['title'] = 'Data Deduksi Anggota';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Deduksi Anggota';

        return view('admin/opt/index', $this->data);
    }

    public function new()
    {
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fieldTypes'] = (new Deduksi())->getField();
        $this->data['action'] = 'admin/deduksi/save';

        return view('admin/deduksi/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = Deduksi::find($id);
        $this->data['title'] = 'Data Deduksi Anggota';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new Deduksi())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'admin/deduksi/update/'.$rows->id;

        return view('admin/deduksi/detail', $this->data);
    }
    public function json()
    {
        $data = Deduksi::select('*')
                ->orderby('tanggal', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = Deduksi::find($id);

        $fillAble = (new Deduksi())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Deduksi())->getFillable();
        Deduksi::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = Deduksi::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
