<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Barang;
use Yajra\DataTables\Facades\DataTables;

class AdminSumberDayaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->page = 'admin/resources';
        $this->middleware('is_admin');
        $this->data['route_new'] = 'admin.resources';
    }

    public function index()
    {
        $this->data['title'] = 'Data Sumber Daya';
        $this->data['sub_title'] = 'List Sumber Daya';

        return view('admin/resources/index', $this->data);
    }

    public function show($id)
    {
        $anime = Barang::findorfail($id);
        $this->data['title'] = 'Data Sumber Daya';
        $this->data['sub_title'] = $anime->title;

        return view('admin/resources/show', $this->data);
    }
    public function new()
    {
        $this->data['title'] = 'Data Sumber Daya';
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fillable'] = (new Barang())->getFillable();
        $this->data['fieldTypes'] = (new Barang())->getField();
        $this->data['action'] = 'admin/resources/save';

        return view('admin/resources/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = Barang::find($id);
        $this->data['title'] = 'Data Sumber Daya';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new Barang())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'admin/resources/update/'.$rows->id;

        return view('admin/resources/detail', $this->data);
    }
    public function json()
    {
        $data = Barang::select('*')
                ->orderby('nama_barang', 'ASC')
                ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = Barang::find($id);

        $fillAble = (new Barang())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Barang())->getFillable();
        Barang::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = Barang::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
