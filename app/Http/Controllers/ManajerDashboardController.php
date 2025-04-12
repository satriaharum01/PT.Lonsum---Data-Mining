<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\Pengadaan;
use Yajra\DataTables\Facades\DataTables;
use App\Http\helpers\Formula;
use Auth;
use App\Services\ForecastService;

class ManajerDashboardController extends Controller
{
    private $alpha = 0.5;
    private $beta = 0.5;
    protected ForecastService $forecastService;

    public function __construct(ForecastService $forecastService)
    {
        $this->middleware('auth');
        $this->middleware('is_manajer');

        $this->forecastService = $forecastService;
    }

    public function index()
    {
        $this->data['title'] = 'Dashboard Manajer';
        $this->data['chartValue'] = $this->barChart();
        $this->data['donatValue'] = $this->donatChart();
        $this->data['chartColor'] = Formula::$chartColor;
        $this->data['chartColor2'] = Formula::$chartColor2;

        return view('manajer/dashboard/index', $this->data);
    }

    public function getCalculate()
    {

        $data = $this->forecastService->generateGraf($this->alpha, $this->beta, 1);

        return $data;
    }

    public function donatChart()
    {
        $data = Barang::select('nama_barang')
        ->withSum('pengadaan as total_jumlah', 'jumlah')
        ->get();

        // Format untuk chart
        $labels = [];
        $values = [];

        foreach ($data as $item) {
            $labels[] = $item->nama_barang;
            $values[$item->nama_barang] = [$item->total_jumlah ?? 0];
        }

        return [
            'labels' => $labels,
            'data' => $values,
        ];
    }

    public function barChart()
    {
        $data = $this->forecastService->generateGraf($this->alpha, $this->beta, 1);
        $labels = $data['label'];
        $value = array('Aktual' => $data['data'],'Prediksi' => $data['forecast']);

        return ['labels' => $labels, 'data' => $value];
    }
}
