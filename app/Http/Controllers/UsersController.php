<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;

use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Data Users';
        $this->data[ 'link' ] = '/admin/pengguna';
        $this->page = 'admin/pengguna';
        $this->view = 'admin/pengguna/index';
        $this->data['page'] = $this->page;
    }

    public function index()
    {
        return view($this->view, $this->data);
    }

    public function destroy($id)
    {
        $rows = User::findOrFail($id);
        $rows->delete();
        return redirect($this->page);

    }

    public function update(Request $request, $id)
    {
        $rows = User::find($id);
        if($request->password == true) {
            $rows->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => $request->level,
                'update_at' => now()
             ]);
        } else {
            $rows->update([
                'name' => $request->name,
                'email' => $request->email,
                'level' => $request->level,
                'update_at' => now()
             ]);
        }

        return redirect($this->page);

    }

    public function store(Request $request)
    {
        if($request->password == true) {
            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => $request->level
            ]);
        } else {
            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'level' => $request->level
            ]);
        }

        return redirect($this->page);

    }

    public function json()
    {
        $data = User::select('*')
                ->orderby('level', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = User::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }

}
