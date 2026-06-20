<?php

namespace App\Services;

class HoltWintersService
{
    /**
     * Prediksi deret waktu menggunakan metode Holt-Winters (Triple Exponential Smoothing)
     * Menggunakan model Additive untuk menangani nilai 0 pada curah hujan.
     *
     * @param  array<int, float>  $data  Data historis (berurutan)
     * @param  int  $period  Panjang musim (seasonality), misal 12 untuk data bulanan
     * @param  int  $forecastLength  Berapa periode ke depan yang ingin diprediksi
     * @param  float  $alpha  Smoothing factor untuk Level
     * @param  float  $beta  Smoothing factor untuk Trend
     * @param  float  $gamma  Smoothing factor untuk Seasonality
     * @return array<int, float> Hasil peramalan untuk $forecastLength periode ke depan
     */
    public function forecast(
        array $data,
        int $period = 12,
        int $forecastLength = 3,
        float $alpha = 0.2,
        float $beta = 0.1,
        float $gamma = 0.2
    ): array {
        $n = count($data);

        // Jika data kurang dari 2 periode musim, kembalikan nilai rata-rata biasa
        if ($n < $period * 2) {
            $avg = $n > 0 ? array_sum($data) / $n : 0;

            return array_fill(0, $forecastLength, round($avg, 2));
        }

        // Inisialisasi Level (S) - Rata-rata dari periode musim pertama
        $S = array_sum(array_slice($data, 0, $period)) / $period;

        // Inisialisasi Trend (T) - Rata-rata perbedaan antara periode musim 2 dan musim 1
        $T = 0;
        for ($i = 0; $i < $period; $i++) {
            $T += ($data[$i + $period] - $data[$i]) / $period;
        }
        $T /= $period;

        // Inisialisasi Seasonality (I)
        $I = [];
        for ($i = 0; $i < $period; $i++) {
            $I[$i] = $data[$i] - $S;
        }

        // Iterasi Smoothing
        for ($t = 0; $t < $n; $t++) {
            if ($t < $period) {
                continue;
            }

            $lastS = $S;
            $lastT = $T;
            $lastI = $I[$t % $period];

            // Formula Holt-Winters Additive
            $S = $alpha * ($data[$t] - $lastI) + (1 - $alpha) * ($lastS + $lastT);
            $T = $beta * ($S - $lastS) + (1 - $beta) * $lastT;
            $I[$t % $period] = $gamma * ($data[$t] - $S) + (1 - $gamma) * $lastI;
        }

        // Peramalan (Forecasting)
        $forecasts = [];
        for ($m = 1; $m <= $forecastLength; $m++) {
            $forecastValue = $S + ($m * $T) + $I[($n - 1 + $m) % $period];
            // Curah hujan tidak mungkin bernilai negatif
            $forecasts[] = max(0, round($forecastValue, 2));
        }

        return $forecasts;
    }
}
