<?php

namespace App\Services;

use App\Models\Pengadaan;
use App\Services\DoubleExponentialSmoothingService;
use Carbon\Carbon;

class ForecastService
{
    protected DoubleExponentialSmoothingService $des;

    public function __construct(DoubleExponentialSmoothingService $des)
    {
        $this->des = $des;
    }

    public function analysData(float $alpha, float $beta, int $id, $startDateMonthYear, $endDateMonthYear): array
    {

        $data = Pengadaan::where('id_barang', $id)
        ->orderBy('tanggal', 'ASC')
        ->whereBetween('tanggal', [$startDateMonthYear, $endDateMonthYear])
        ->get()
        ->map(function ($row) {
            return [
                'jumlah' => $row->jumlah,
                'tanggal' => \Carbon\Carbon::parse($row->tanggal)->format('Y-m'),
            ];
        })
        ->toArray();
        if (count($data) < 3) {
            return response()->json(['message' => 'Minimal 3 data diperlukan untuk TES'], 422);
        }

        // Hitung Single, Double, Triple Smoothing (S1, S2, S3) di service
        $smoothingService = new TripleExponentialSmoothingService($alpha, $beta);
        $smoothingResult = $smoothingService->forecast($data);

        $result = [];
        $At = $Bt = $Ct = [];

        foreach ($smoothingResult as $i => $row) {
            $jumlah = $row['jumlah'];
            $S1 = $row['single'];
            $S2 = $row['double'];
            $S3 = $row['triple'];

            if ($i == 0) {
                $At[$i] = $Bt[$i] = $Ct[$i] = null;
                $forecast = null;
            } else {
                // Hitung At, Bt, Ct
                $At[$i] = 3 * $S1 - 3 * $S2 + $S3;
                $Bt[$i] = ($alpha / 2) * ((6 - 5 * $alpha) * $S1 - (10 - 8 * $alpha) * $S2 + (4 - 3 * $alpha) * $S3);
                $Ct[$i] = ($alpha ** 2 / 2) * ($S1 - 2 * $S2 + $S3);

                // Hitung TES
                $forecast = round($At[$i] + $Bt[$i] + 0.5 * $Ct[$i], 2);
            }

            $result[] = [
                'tanggal' => $row['tanggal'],
                'jumlah' => $jumlah,
                'single' => round($S1, 2),
                'double' => round($S2, 2),
                'triple' => round($S3, 2),
                'at' => $At[$i] !== null ? round($At[$i], 2) : null,
                'bt' => $Bt[$i] !== null ? round($Bt[$i], 2) : null,
                'ct' => $Ct[$i] !== null ? round($Ct[$i], 2) : null,
                'forecast' => $forecast,
            ];
        }

        // Tambahkan forecast masa depan (misal 4 periode)
        $last = count($smoothingResult) - 1;
        $lastDate = \Carbon\Carbon::parse($smoothingResult[$last]['tanggal']);

        for ($m = 1; $m <= 4; $m++) {
            $forecastValue = $At[$last] + $Bt[$last] * $m + 0.5 * $Ct[$last] * ($m ** 2);
            $tanggal = $lastDate->copy()->addMonths($m)->format('Y-m');

            $result[] = [
                'tanggal' => $tanggal,
                'jumlah' => null,
                'single' => null,
                'double' => null,
                'triple' => null,
                'at' => null,
                'bt' => null,
                'ct' => null,
                'forecast' => round($forecastValue, 2),
            ];
        }

        return $result;

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
            } else {
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
