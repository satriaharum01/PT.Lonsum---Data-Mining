<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use Hash;
use File;

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

        $this->page = 'admin/profile';
        $this->data['title'] = 'Profile Pengguna';
    }

    public function index()
    {
        $rows = User::find(Auth::user()->id);
        $this->data['title'] = 'Profile Pengguna';
        $this->data['sub_title'] = 'Profile Pengguna ';
        $this->data['fieldTypes'] = (new User())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'admin/profile/update/'.$rows->id;

        return view('profile', $this->data);
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
        if($request->file('photos'))
        {
            $file = $request->file('photos');
            $filename = Auth::user()->id . '.jpg';
            $this->image_destroy($filename);
            $file->storeAs('', $filename, ['disk' => 'faces_upload']);
            $data['faces'] = $filename;
        }
        $rows->update($data);

        return redirect($this->page);
    }

}
