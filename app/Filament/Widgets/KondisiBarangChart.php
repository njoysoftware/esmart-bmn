<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Barang;

class KondisiBarangChart extends ChartWidget
{
    protected ?string $heading = 'Kondisi Barang BMN';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 1;
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'data' => [
                        Barang::where('kondisi', 'baik')->count(),
                        Barang::where('kondisi', 'rusak ringan')->count(),
                        Barang::where('kondisi', 'rusak berat')->count(),
                    ],

                    // 🔥 WARNA PIE CHART
                    'backgroundColor' => [
                        '#22c55e', // hijau (baik)
                        '#f59e0b', // kuning (rusak ringan)
                        '#ef4444', // merah (rusak berat)
                    ],

                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],

            'labels' => ['Baik', 'Rusak Ringan', 'Rusak Berat'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
