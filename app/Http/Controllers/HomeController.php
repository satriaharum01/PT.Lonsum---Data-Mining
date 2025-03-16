<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Laporan;
use App\Models\Notif;
use App\Models\OPT;
use App\Models\Petugas;
use App\Models\Tanaman;
use App\Models\User;
use App\Models\Verifikasi;
use App\Models\WilayahKerja;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['title'] = env('APP_NAME');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return redirect()->to(route('login'));
        return view('landing/index', $this->data);
    }

    public function login()
    {
        $this->data['alertMessage'] = '';
        return view('auth/login', $this->data);
    }

    //GeT FUnction

    public function getKabupaten()
    {
        $data = Kabupaten::select('*')
                ->orderby('nama_kabupaten', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getUsersLevel($level)
    {
        if($level == 'all'){$level = '';}

        $data = User::select('*')
                ->where('level',$level)
                ->orderby('name', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getKecamatan()
    {
        $data = Kecamatan::select('*')
                ->orderby('nama_kecamatan', 'DESC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getWilayahKerja($id)
    {
        $kecamatan = Kecamatan::select('id')->where('kabupaten_id',$id)->get()->toArray();
        $data = WilayahKerja::select('*')
                ->whereIn('kecamatan_id',$kecamatan)
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function getTanaman()
    {
        $data = Tanaman::select('*')
                ->orderby('nama_tanaman', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    
    public function getOPT()
    {
        $data = OPT::select('*')
                ->orderby('nama_opt', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    //FiND
    public function findKabupaten($id)
    {
        $data = Kabupaten::select('*')
                ->where('id',$id)
                ->orderby('nama_kabupaten', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function findKecamatan($id)
    {
        $data = Kecamatan::select('*')
                ->where('kabupaten_id',$id)
                ->orderby('nama_kecamatan', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function findPetugas($id)
    {
        $data = Petugas::select('*')
                ->where('user_id',$id)
                ->get();
        foreach($data as $row)
        {
            $row->name = $row->cariUser->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
