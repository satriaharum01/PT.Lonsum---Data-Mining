<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Pengadaan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ManajerHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->page = 'manajer/history';
        $this->middleware('is_manajer');
        $this->data['route_new'] = 'manajer.history';
    }

    public function index()
    {
        $this->data['title'] = 'Data History';
        $this->data['subTitle'] = 'List History Data Stok';
        $this->data['page'] = 'History';

        return view('manajer/history/index', $this->data);
    }
    public function cetak()
    {
        $this->data['title'] = 'Cetak Data History';
        $this->data['subTitle'] = 'Data Historis';
        $this->data['page'] = 'Laporan';

        $tahun = $this->getTahunUnik();

        $pengadaanSummary = Pengadaan::select(
            DB::raw('YEAR(tanggal) as tahun'),
            'id_barang',
            DB::raw('SUM(jumlah) as total_jumlah')
        )
        ->groupBy('tahun', 'id_barang')
        ->with('cariBarang') // biar bisa ambil nama_barang
        ->get()
        ->map(function ($item) {
            return [
                'tahun' => $item->tahun,
                'id_barang' => $item->id_barang,
                'nama_barang' => $item->cariBarang->nama_barang ?? 'deleted data',
                'total_jumlah' => (float) $item->total_jumlah,
                'satuan' => $item->cariBarang->satuan ?? '',
            ];
        });

        if (!$pengadaanSummary) {
            abort(404, 'Data Historis tidak ditemukan.');
        }

        if (!$tahun) {
            abort(404, 'Data Historis tidak ditemukan.');
        }
        // Ambil input dan kasih default
        $start = $tahun[0];
        $end = end($tahun);

        // Cek validasi input wajib
        if (!$start || !$end) {
            abort(404, 'Data Historis tidak ditemukan.');
        }

        // Format tanggal awal & akhir dari input type="month"
        $this->data['start'] = $start;
        $this->data['end'] = $end;
        $this->data['dataList'] = $pengadaanSummary;

        return view('admin/history/cetak', $this->data);
    }

}
