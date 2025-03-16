<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\helpers\Formula;
use Auth;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index()
    {
        $this->data['title'] = 'Dashboard Admin';
        $this->data['laporan'] = 0;
        $this->data['laporan_menunggu'] = 0;
        $this->data['laporan_verifikasi'] = 0;
        $this->data['kabupaten'] = 0;
        $this->data['kecamatan'] = 0;
        $this->data['wilayahKerja'] = 0;
        $this->data['tanaman'] = 0;
        $this->data['opt'] = 0;
        $this->data['chartValue'] = 0;
        $this->data['chartColor'] = Formula::$chartColor;

        return view('admin/dashboard/index', $this->data);
    }


    public function json()
    {
    }


    public function barChart()
    {

        $tanaman = Tanaman::select('id', 'nama_tanaman')->get(); // Ambil id dan nama tanaman langsung

        // Query untuk data laporan
        $data = Laporan::selectRaw("
            tanaman_id,
            MONTH(CONCAT(bulan_tahun, '-01')) as bulan,
            SUM(r_serang + s_serang + b_serang + p_serang) as total_serangan
        ")
                ->whereRaw("SUBSTRING(bulan_tahun, 1, 4) = ?", [date('Y')]) // Tahun berjalan
                ->whereIn('tanaman_id', $tanaman->pluck('id')) // ID tanaman diambil dari hasil query
                ->groupBy('tanaman_id', 'bulan')
                ->orderBy('bulan', 'ASC')
                ->get();

        // Format label bulan
        $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Inisialisasi array nilai untuk setiap tanaman
        $value = [];
        foreach ($tanaman as $tanam) {
            $value[$tanam->nama_tanaman] = array_fill(0, 12, 0); // Isi default 0 untuk setiap bulan
        }

        // Isi nilai total serangan berdasarkan data laporan
        foreach ($data as $row) {
            $tanam = $tanaman->firstWhere('id', $row->tanaman_id); // Cocokkan tanaman_id
            $index = $row->bulan - 1; // Konversi ke index array (0 - 11)
            $value[$tanam->nama_tanaman][$index] = $row->total_serangan;
        }

        // Return data yang telah diolah
        return ['labels' => $labels,'data' => $value];
    }
}
