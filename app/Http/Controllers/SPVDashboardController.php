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

class SPVDashboardController extends Controller
{
    private $alpha = 0.5;
    private $beta = 0.5;
    protected ForecastService $forecastService;

    public function __construct(ForecastService $forecastService)
    {
        $this->middleware('auth');
        $this->middleware('is_spv');

        $this->forecastService = $forecastService;
    }

    public function index()
    {
        $this->data['title'] = 'Dashboard Manajer';
        $this->data['chartValue'] = $this->barChart(1);
        $this->data['donatValue'] = $this->donatChart(1);
        $this->data['chartColor'] = Formula::$chartColor;
        $this->data['bgChartColor'] = Formula::$bgChartColor;
        $this->data['chartColor2'] = Formula::$chartColor2;
        $this->data['cpo'] = $this->countCPO();
        $this->data['ffb'] = $this->countFFB();
        $this->data['barang'] = Barang::select('*')->get();

        return view('spv/dashboard/index', $this->data);
    }

    public function getCalculate()
    {

        $data = $this->forecastService->generateGraf($this->alpha, $this->beta, 1);

        return $data;
    }

    public function donatChart()
    {
        $getYear = $this->getTahunTerakhir();
        $data = Barang::select('nama_barang')
        ->whereHas('pengadaan', function ($query) use ($getYear) {
            $query->where('tanggal', 'like', "%$getYear%");
        })
        ->withSum(['pengadaan as total_jumlah' => function ($query) use ($getYear) {
            $query->where('tanggal', 'like', "%$getYear%");
        }], 'jumlah')
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

    public function barChart($id)
    {
        $data = $this->forecastService->generateGraf($this->alpha, $this->beta, $id);
        $labels = $data['label'];
        $value = array('Aktual' => $data['data'],'Prediksi' => $data['forecast']);

        return ['labels' => $labels, 'data' => $value];
    }
}
