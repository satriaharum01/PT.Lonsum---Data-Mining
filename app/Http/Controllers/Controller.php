<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\DoubleExponentialSmoothingService;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Notif;
use App\Models\User;
use App\Models\Barang;
use App\Models\Pengadaan;
use Auth;
use File;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public $bulan = array('','Januari','Febuari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    public $hari = [
        "","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu","Minggu"
    ];

    public function buat_notif($title, $icon, $color)
    {
        $data = [
            'judul' => $title,
            'status' => 'wait',
            'icon' => $icon,
            'color' => $color,
            'id_user' => Auth::user()->id
        ];

        Notif::create($data);
    }

    public function generateGraf($alpha, $beta, $id, DoubleExponentialSmoothingService $des)
    {
        $data = Pengadaan::where('id_barang', $id)
            ->orderBy('tanggal', 'ASC')
            ->get()
            ->toArray();

        // Inject alpha & beta
        $des->setAlpha($alpha)->setBeta($beta);

        $desResult = $this->DES($data, $des);
        unset($desResult['unit']);

        $value = [];
        $forecast = [];
        $label = [];

        $dataCount = count($desResult);
        foreach (array_values($desResult) as $index => $row) {
            $isLast = ($index === $dataCount - 1);

            $label[] = $row['tanggal'];
            if ($isLast) {
                $forecast[] = $this->is_decimal($row['forecast']);
            } else {
                $value[] = $this->is_decimal($row['jumlah']);
                $forecast[] = 0;
            }
        }

        return [
            'data' => $value,
            'label' => $label,
            'forecast' => $forecast,
        ];
    }


    public function result_prediksi($start, $end, $alpha, $beta, $filter)
    {
        $tglStart = date('Y-m-01', strtotime($start));
        $tglEnd = date('Y-m-t', strtotime($end));

        $barangList = Barang::all();

        $unit = [
            'rmse' => 0,
            'mse' => 0,
            'mad' => 0,
            'mape' => 0,
            'summary' => [],
        ];

        $filteredBarang = [];

        foreach ($barangList as $barang) {
            $data = Pengadaan::where('id_barang', $barang->id_barang)
                ->whereBetween('tanggal', [$tglStart, $tglEnd])
                ->orderBy('tanggal', 'ASC')
                ->get()
                ->toArray();

            if (empty($data)) {
                return '<script>alert("Data Kosong !!!")</script>';
            }

            $desResult = $this->DES($data, $alpha, $beta);
            $summary = $desResult['unit']['summary'];

            if ($summary === $filter) {
                $cd = count($desResult);

                $barang->full = $barang->satuan;
                $barang->last = $this->is_decimal($desResult[$cd - 3]['jumlah']);
                $barang->new = $this->is_decimal($desResult[$cd - 2]['forecast']);
                $barang->last_label = 'Data Terakhir';

                // Copy unit metrics to barang
                foreach (['rmse', 'mse', 'mad', 'mape'] as $metric) {
                    $barang->{$metric} = $metric === 'mape'
                        ? $desResult['unit'][$metric] . '%'
                        : $desResult['unit'][$metric];
                    $unit[$metric] += $desResult['unit'][$metric];
                }

                $barang->summary = $summary;
                $unit['summary'][] = $summary;

                $filteredBarang[] = $barang;
            }
        }

        $countBarang = count($filteredBarang);
        if ($countBarang <= 0) {
            return '<script>alert("Data Kosong !!!")</script>';
        }

        foreach (['rmse', 'mse', 'mad', 'mape'] as $metric) {
            $unit[$metric] = round($unit[$metric] / $countBarang, 2);
        }

        // Ambil nilai summary yang paling banyak muncul
        $summaryCount = array_count_values($unit['summary']);
        $unit['summary'] = array_key_first($summaryCount);

        $this->data['unit'] = $unit;
        $this->data['barang'] = $filteredBarang;

        return view('admin.engine.result', $this->data);
    }

    public function is_decimal($val)
    {
        return (is_numeric($val) && floor($val) != $val) ? round($val, 2) : $val;
    }

    public function num_of_weeks($val)
    {
        return match ((int)$val) {
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            default => 'th',
        };
    }

    public function DES($data = array(), DoubleExponentialSmoothingService $des)
    {
        $count_data = count($data);
        if ($count_data == 0) {
            return [
                'unit' => [
                    'rmse' => 0,
                    'mse' => 0,
                    'mad' => 0,
                    'summary' => 'Tidak Ada',
                    'mape' => 0,
                    'alpha' => $this->alpha,
                    'beta' => $this->beta
                ]
            ];
        }

        $result = $des->calculate($data);

        return $result;
    }

    public function image_destroy($filename)
    {
        if (File::exists(public_path('/assets/images/laporan/' . $filename . ''))) {
            File::delete(public_path('/assets/images/laporan/' . $filename . ''));
        }
    }
    public function profile_destroy($filename)
    {
        if (File::exists(public_path('/assets/img/faces/' . $filename . ''))) {
            File::delete(public_path('/assets/img/faces/' . $filename . ''));
        }
    }
}
