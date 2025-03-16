<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Shipment;
use Yajra\DataTables\Facades\DataTables;

class AdminShipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->page = 'admin/kabupaten';
        $this->middleware('is_admin');
    }

    public function index()
    {
        $this->data['title'] = 'Data Kabupaten';
        $this->data['sub_title'] = 'List Data Kabupaten';

        return view('admin/kabupaten/index', $this->data);
    }

    public function show($id)
    {
        $anime = Kabupaten::findorfail($id);
        $this->data['title'] = 'Data Kabupaten';
        $this->data['sub_title'] = $anime->title;

        return view('admin/kabupaten/show', $this->data);
    }
    public function new()
    {
        $this->data['title'] = 'Data Kabupaten';
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fillable'] = (new Kabupaten())->getFillable();
        $this->data['fieldTypes'] = (new Kabupaten())->getField();
        $this->data['action'] = 'admin/kabupaten/save';

        return view('admin/kabupaten/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = Kabupaten::find($id);
        $this->data['title'] = 'Data Kabupaten';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new Kabupaten())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'admin/kabupaten/update/'.$rows->id;

        return view('admin/kabupaten/detail', $this->data);
    }
    public function json()
    {
        $data = Kabupaten::select('*')
                ->orderby('nama_kabupaten', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = Kabupaten::find($id);

        $fillAble = (new Kabupaten())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Kabupaten())->getFillable();
        Kabupaten::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = Kabupaten::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
