<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Laporan;
use App\Models\Pengadaan;
use App\Models\Notif;
use App\Models\Prediksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Services\ForecastService;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected ForecastService $forecastService;

    private $alpha = 0.5;
    private $beta = 0.5;

    public function __construct(ForecastService $forecastService)
    {
        $this->data['title'] = env('APP_NAME');

        $this->forecastService = $forecastService;
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
    public function getBarang()
    {
        $data = Barang::select('*')
                ->orderby('nama_barang', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getUsersLevel($level)
    {
        if ($level == 'all') {
            $level = '';
        }

        $data = User::select('*')
                ->where('level', $level)
                ->orderby('name', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getTahunUnik()
    {
        $years = Pengadaan::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->toArray();

        return response()->json($years);
    }

    //Prediction
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

    public function prediksiStore(Request $request)
    {
        $fillAble = (new Prediksi())->getFillable();
        $data = Prediksi::create($request->only($fillAble));

        return response()->json(['message' => 'Data created successfully', 'data' => $data], 201);
    }

    public function prediksiDestroy($id)
    {
        $rows = Prediksi::findOrFail($id);
        $rows->delete();

        return response()->json(['message' => 'Data destroy successfully', 'data' => $rows], 201);
    }

    public function prediksiCetak($id)
    {

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

        // Return DataTables response
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function history()
    {
        $data = Pengadaan::select('*')
                ->orderby('tanggal', 'DESC')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'id_barang' => $item->id_barang,
                        'nama_barang' => $item->cariBarang->nama_barang ?? 'deleted data', // fallback kalau null
                        'timestamp' => date('d F Y H:i', strtotime($item->created_at)),
                        'jumlah' => $item->jumlah.' '.$item->cariBarang->satuan,
                        'tanggal' => date('d F Y', strtotime($item->tanggal)),
                    ];
                });

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function filterData(Request $request)
    {
        $data = Pengadaan::select('*')
                ->orderby('tanggal', 'DESC')
                ->when($request->id_barang, fn ($query, $barang) => $query->where('id_barang', $barang))
                ->when(
                    $request->periode,
                    fn ($query, $periode) =>
            $query->whereYear('tanggal', $periode)
                )->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'id_barang' => $item->id_barang,
                        'nama_barang' => $item->cariBarang->nama_barang ?? 'deleted data', // fallback kalau null
                        'timestamp' => date('d F Y H:i', strtotime($item->created_at)),
                        'jumlah' => $item->jumlah.' '.$item->cariBarang->satuan,
                        'tanggal' => date('d F Y', strtotime($item->tanggal)),
                    ];
                });

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getChartData($id)
    {
        $data = $this->forecastService->generateGraf($this->alpha, $this->beta, $id);
        $labels = $data['label'];
        $value = array('Aktual' => $data['data'],'Prediksi' => $data['forecast']);

        return ['labels' => $labels, 'data' => $value];
    }

    public function jsonPrediksi()
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
