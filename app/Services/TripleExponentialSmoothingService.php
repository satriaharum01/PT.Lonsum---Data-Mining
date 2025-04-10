<?php

namespace App\Services;

class TripleExponentialSmoothingService
{
    protected $alpha;
    protected $beta;

    public function __construct($alpha, $beta)
    {
        $this->alpha = $alpha;
        $this->beta = $beta;
    }

    public function forecast(array $data, int $steps = 4): array
    {
        $S1 = $S2 = $S3 = [];
        $result = [];

        foreach ($data as $i => $row) {
            $x = $row['jumlah'];

            if ($i == 0) {
                $S1[$i] = $x;
                $S2[$i] = $x;
                $S3[$i] = $x;
            } else {
                $S1[$i] = $this->alpha * $x + (1 - $this->alpha) * $S1[$i - 1];
                $S2[$i] = $this->alpha * $S1[$i] + (1 - $this->alpha) * $S2[$i - 1];
                $S3[$i] = $this->alpha * $S2[$i] + (1 - $this->alpha) * $S3[$i - 1];
            }

            $result[] = [
                'tanggal' => $row['tanggal'],
                'jumlah' => $x,
                'single' => $S1[$i],
                'double' => $S2[$i],
                'triple' => $S3[$i],
            ];
        }

        return $result;
    }
}
