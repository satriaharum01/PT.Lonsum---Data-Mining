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
}
