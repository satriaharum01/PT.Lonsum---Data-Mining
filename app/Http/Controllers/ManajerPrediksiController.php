<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Barang;
use App\Models\Pengadaan;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ForecastService;
use Carbon\Carbon;

class ManajerPrediksiController extends Controller
{
    protected ForecastService $forecastService;

    public function __construct(ForecastService $forecastService)
    {
        $this->middleware('auth');
        $this->page = 'manajer/prediksi';
        $this->middleware('is_manajer');
        $this->data['route_new'] = 'manajer.prediksi';

        $this->forecastService = $forecastService;
    }

    public function index()
    {
        $this->data['title'] = 'Laporan Prediksi';
        $this->data['sub_title'] = 'Prediksi Pengadaan Sumber Daya';

        return view('manajer/prediksi/index', $this->data);
    }

    public function analys(Request $request)
    {
        // Ambil input dan kasih default
        $alpha = $request->input('alpha', 0.1);
        $beta = $request->input('beta', 0.1);
        $id = $request->input('id');
        $start = $request->input('awal');
        $end = $request->input('akhir');

        // Cek validasi input wajib
        if (!$start || !$end || !$id) {
            return DataTables::of([])->addIndexColumn()->make(true);
        }

        // Format tanggal awal & akhir dari input type="month"
        $startDate = Carbon::parse($start)->startOfMonth()->toDateString(); // ex: 2025-03-01
        $endDate = Carbon::parse($end)->endOfMonth()->toDateString();       // ex: 2025-03-31

        // Proses forecasting via service
        $data = $this->forecastService->analysData($alpha, $beta, $id, $startDate, $endDate);

        // Return DataTables response
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
