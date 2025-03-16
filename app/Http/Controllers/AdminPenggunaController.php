<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Petugas;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use Hash;

class AdminPenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

        $this->page = 'admin/pengguna';
        $this->data['title'] = 'Data Pengguna';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Pengguna';

        return view('admin/pengguna/index', $this->data);
    }

    public function new()
    {
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fieldTypes'] = (new User())->getField();
        $this->data['action'] = 'admin/pengguna/save';

        return view('admin/pengguna/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = User::find($id);
        $this->data['title'] = 'Data Pengguna';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new User())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'admin/pengguna/update/'.$rows->id;

        return view('admin/pengguna/detail', $this->data);
    }
    public function json()
    {
        $data = User::select('*')
                ->orderby('name', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = User::find($id);

        $fillAble = (new User())->getFillable();
        $data = $request->only($fillAble);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $rows->update($data);

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new User())->getFillable();

        $data = $request->only($fillAble);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        User::create($data);

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = User::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
