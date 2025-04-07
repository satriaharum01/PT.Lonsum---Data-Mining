<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Pengadaan;
use Yajra\DataTables\Facades\DataTables;

class AdminStokingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->page = 'admin/stoking';
        $this->middleware('is_admin');
        $this->data['route_new'] = 'admin.stoking';
    }

    public function index()
    {
        $this->data['title'] = 'Data Pengadaan';
        $this->data['sub_title'] = 'List Pengadaan Sumber Daya';

        return view('admin/stoking/index', $this->data);
    }

    public function show($id)
    {
        $anime = Pengadaan::findorfail($id);
        $this->data['title'] = 'Data Pengadaan';
        $this->data['sub_title'] = $anime->title;

        return view('admin/stoking/show', $this->data);
    }
    public function new()
    {
        $this->data['title'] = 'Data Pengadaan';
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fillable'] = (new Pengadaan())->getFillable();
        $this->data['fieldTypes'] = (new Pengadaan())->getField();
        $this->data['action'] = 'admin/stoking/save';

        return view('admin/stoking/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = Pengadaan::find($id);
        $this->data['title'] = 'Data Pengadaan';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new Pengadaan())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'admin/stoking/update/'.$rows->id;

        return view('admin/stoking/detail', $this->data);
    }
    public function json()
    {
        $data = Pengadaan::select('*')
                ->orderby('tanggal', 'DESC')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'id_barang' => $item->id_barang,
                        'nama_barang' => $item->cariBarang->nama_barang ?? 'deleted data', // fallback kalau null
                        'jumlah' => $item->jumlah,
                        'tanggal' => date('d F Y', strtotime($item->tanggal)),
                    ];
                });

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = Pengadaan::find($id);

        $fillAble = (new Pengadaan())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Pengadaan())->getFillable();
        Pengadaan::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = Pengadaan::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
