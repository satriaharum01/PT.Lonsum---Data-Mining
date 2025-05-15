<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Prediksi;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ForecastService;
use Carbon\Carbon;

class ManajerLaporanController extends Controller
{
    public function __construct(ForecastService $forecastService)
    {
        $this->middleware('auth');
        $this->page = 'manajer/prediksi';
        $this->middleware('is_manajer');

        $this->forecastService = $forecastService;
    }

    public function index()
    {
        $this->data['title'] = 'Laporan Data Prediksi';
        $this->data['subTitle'] = 'List History Prediksi';
        $this->data['page'] = 'Laporan';

        return view('manajer/laporan/index', $this->data);
    }

    public function cetak($id)
    {
        $this->data['title'] = 'Cetak Data Prediksi';
        $this->data['subTitle'] = 'Data Prediksi';
        $this->data['page'] = 'Laporan';

        $dataPredict = Prediksi::findorfail($id);

        if (!$dataPredict) {
            abort(404, 'Data prediksi tidak ditemukan.');
        }
        // Ambil input dan kasih default
        $alpha = $dataPredict->alpha;
        $beta = $dataPredict->beta;
        $id = $dataPredict->id_barang;
        $start = $dataPredict->startPeriod;
        $end = $dataPredict->endPeriod;

        // Cek validasi input wajib
        if (!$start || !$end || !$id) {
            abort(404, 'Data prediksi tidak ditemukan.');
        }

        // Format tanggal awal & akhir dari input type="month"
        $startDate = Carbon::parse($start)->startOfMonth()->toDateString(); // ex: 2025-03-01
        $endDate = Carbon::parse($end)->endOfMonth()->toDateString();       // ex: 2025-03-31

        // Proses forecasting via service
        $data = $this->forecastService->analysData($alpha, $beta, $id, $startDate, $endDate);
        $this->data['barang'] = $dataPredict->cariBarang->nama_barang;
        $this->data['start'] = $start;
        $this->data['end'] = $end;
        $this->data['prediksiList'] = $data;

        return view('manajer/laporan/cetak', $this->data);
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
