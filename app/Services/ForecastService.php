<?php

namespace App\Services;

use App\Models\Pengadaan;
use App\Services\DoubleExponentialSmoothingService;

class ForecastService
{
    protected DoubleExponentialSmoothingService $des;

    public function __construct(DoubleExponentialSmoothingService $des)
    {
        $this->des = $des;
    }

    public function generateGraf(float $alpha, float $beta, int $id): array
    {
        $data = Pengadaan::where('id_barang', $id)
        ->orderBy('tanggal', 'ASC')
        ->get()
        ->map(function ($row) {
            return [
                'jumlah' => $row->jumlah,
                'tanggal' => \Carbon\Carbon::parse($row->tanggal)->format('Y-m'),
            ];
        })
        ->toArray();

        $desService = new DoubleExponentialSmoothingService($alpha, $beta);
        $desResult = $desService->calculate($data);

        // ambil nilai-nilai untuk chart
        $value = $forecast = $label = [];
        $dataCount = count($desResult) - 1;

        foreach ($desResult as $i => $row) {
            if ($i === 'unit') {
                continue;
            }

            $isLast = ($i === $dataCount);
            $label[] = $row['tanggal'];
            if (!$isLast) {
                $value[] = round($row['jumlah'], 2);
                $forecast[] = round($row['forecast'], 2);
            }else{
                $forecast[] = round($row['forecast'], 2);
            }
        }

        return [
            'data' => $value,
            'label' => $label,
            'forecast' => $forecast,
        ];
    }
}
