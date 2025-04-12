<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Prediksi;
use Yajra\DataTables\Facades\DataTables;

class SPVLaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->page = 'spv/prediksi';
        $this->middleware('is_spv');
    }

    public function index()
    {
        $this->data['title'] = 'Laporan Data Prediksi';
        $this->data['subTitle'] = 'List History Prediksi';
        $this->data['page'] = 'Laporan';

        return view('spv/laporan/index', $this->data);
    }

    public function json()
    {
        $data = Prediksi::select('*')
                ->orderby('created_at', 'DESC')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'id_barang' => $item->id_barang,
                        'beta' => $item->beta,
                        'alpha' => $item->alpha,
                        'nama_barang' => $item->cariBarang->nama_barang ?? 'deleted data', // fallback kalau null
                        'end' => date('Y F', strtotime($item->endPeriod)),
                        'start' => date('Y F', strtotime($item->startPeriod)),
                        'timestamp' => date('d F Y H:i', strtotime($item->created_at)),
                    ];
                });

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

}
