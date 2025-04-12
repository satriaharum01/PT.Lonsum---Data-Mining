<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Pengadaan;
use Yajra\DataTables\Facades\DataTables;

class SPVHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->page = 'spv/history';
        $this->middleware('is_spv');
        $this->data['route_new'] = 'spv.history';
    }

    public function index()
    {
        $this->data['title'] = 'Data History';
        $this->data['subTitle'] = 'List History Data Stok';
        $this->data['page'] = 'History';

        return view('spv/history/index', $this->data);
    }

    public function json()
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
}
