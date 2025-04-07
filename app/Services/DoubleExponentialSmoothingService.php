<?php

namespace App\Services;

class DoubleExponentialSmoothingService
{
    protected float $alpha = 0.5;
    protected float $beta = 0.5;

    public function setAlpha(float $alpha): self
    {
        $this->alpha = $alpha;
        return $this;
    }

    public function setBeta(float $beta): self
    {
        $this->beta = $beta;
        return $this;
    }

    public function calculate(array $data): array
    {
        $results = [];
        $s1 = $s2 = $s3 = 0;
        $level = 0;
        $trend = 0;
        $mse = $mad = $mape = $rmse = 0;
        $count = count($data);

        foreach ($data as $i => $row) {
            $xt = $row['jumlah'];
            $tanggal = $row['tanggal'] ?? now()->addMonths($i)->format('Y-m');

            if ($i === 0) {
                $s1 = $xt;
                $s2 = $xt;
                $s3 = $xt;
                $level = $xt;
                $trend = 0;
                $forecast = 0;
            } elseif ($i === 1) {
                $s1 = $this->alpha * $xt + (1 - $this->alpha) * $s1;
                $s2 = $this->alpha * $s1 + (1 - $this->alpha) * $s2;
                $s3 = $this->alpha * $s2 + (1 - $this->alpha) * $s3;
                $level = $s1;
                $trend = $xt - $data[$i - 1]['jumlah'];
                $forecast = 0;
            } else {
                $s1 = $this->alpha * $xt + (1 - $this->alpha) * $s1;
                $s2 = $this->alpha * $s1 + (1 - $this->alpha) * $s2;
                $s3 = $this->alpha * $s2 + (1 - $this->alpha) * $s3;

                $a = 3 * $s1 - 3 * $s2 + $s3;
                $b = ($this->alpha / 2) * ((6 - 5 * $this->alpha) * $s1 - 2 * (5 - 4 * $this->alpha) * $s2 + (4 - 3 * $this->alpha) * $s3);
                $c = (pow($this->alpha, 2) / 2) * ($s1 - 2 * $s2 + $s3);

                $forecast = $a + $b + $c;
                $level = $a;
                $trend = $b;
            }

            $error = $forecast !== 0 ? $xt - $forecast : 0;
            $squareError = pow($error, 2);
            $absError = abs($error);
            $ape = $xt != 0 ? abs($error / $xt) * 100 : 0;

            $mse += $squareError;
            $mad += $absError;
            $mape += $ape;

            $results[] = [
                'no' => $i + 1,
                'tanggal' => $tanggal,
                'jumlah' => $xt,
                'level' => round($level, 2),
                'trend' => round($trend, 2),
                'forecast' => round($forecast, 2),
                'error' => round($error, 2),
                'single' => round($s1, 2),
                'double' => round($s2, 2),
                'triple' => round($s3, 2),
                'konstanta1' => round($a ?? 0, 2),
                'konstanta2' => round($b ?? 0, 2),
                'konstanta3' => round($c ?? 0, 2),
                'sq_error' => round($squareError, 2),
                'abs_error' => round($absError, 2),
                'ape' => round($ape, 2),
            ];
        }
        /*
        $results['unit'] = [
            'rmse' => round(sqrt($mse / $count), 2),
            'mad' => round($mad / $count, 2),
            'mse' => round($mse / $count, 2),
            'mape' => round($mape / $count, 2),
            'summary' => 'Double Exponential Smoothing',
            'alpha' => $this->alpha,
            'beta' => $this->beta
        ];*/

        return $results;
    }


}
