<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\WilayahKerja;
use App\Models\Laporan;
use App\Models\Tanaman;
use App\Models\Verifikasi;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\helpers\Formula;
use Auth;

class AdminLaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

        $this->page = 'admim/laporan';
        $this->data['title'] = 'Data Laporan';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Laporan';

        return view('admin/laporan/index', $this->data);
    }

    public function json()
    {
        $rekaptulasi = []; // Inisialisasi array kosong

        // Ambil data laporan dan join dengan relasi yang dibutuhkan
        $data = Laporan::whereHas('verifikasi', function ($query) {
            $query->where('status', 'diterima');
        })->with([
            'cariWilayahKerja.cariKecamatan.cariKabupaten',
            'cariOPT',
            'cariTanaman'
        ])
            ->orderBy('wilayah_kerja_id', 'ASC')
            ->orderBy('tanaman_id', 'ASC')
            ->orderBy('opt_id', 'ASC')
            ->orderBy('bulan_tahun', 'DESC')
            ->get();

        // Proses data
        foreach ($data as $row) {
            // Tambahkan informasi tambahan
            $row->nama_kabupaten = $row->cariWilayahKerja->cariKecamatan->cariKabupaten->nama_kabupaten;
            $row->jenis_opt = $row->cariOPT->nama_opt;
            $row->tanaman = $row->cariTanaman->nama_tanaman;
            $row->periode = Formula::$periode[$row->periode] . ' ' . date('F Y', strtotime($row->bulan_tahun));

            // Cari apakah data dengan kriteria yang sama sudah ada
            $key = collect($rekaptulasi)->search(function ($item) use ($row) {
                return $item->nama_kabupaten == $row->nama_kabupaten &&
                       $item->opt_id == $row->opt_id &&
                       $item->periode == $row->periode;
            });

            // Gabungkan data jika sudah ada
            if ($key !== false) {
                $rekaptulasi[$key]->r_serang += $row->r_serang;
                $rekaptulasi[$key]->s_serang += $row->s_serang;
                $rekaptulasi[$key]->b_serang += $row->b_serang;
                $rekaptulasi[$key]->p_serang += $row->p_serang;
            } else {
                // Tambahkan data baru
                $rekaptulasi[] = $row;
            }
        }

        // Format data jumlah menjadi 2 desimal
        foreach ($rekaptulasi as &$item) {
            $item->r_serang = number_format($item->r_serang, 2);
            $item->s_serang = number_format($item->s_serang, 2);
            $item->b_serang = number_format($item->b_serang, 2);
            $item->p_serang = number_format($item->p_serang, 2);
            $item->j_serang = number_format($item->r_serang + $item->s_serang + $item->b_serang + $item->p_serang, 2);
        }
        return Datatables::of($rekaptulasi)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = Laporan::find($id);

        $fillAble = (new Laporan())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Laporan())->getFillable();
        Laporan::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = Laporan::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
