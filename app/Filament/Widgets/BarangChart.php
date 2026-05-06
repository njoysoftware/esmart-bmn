<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Barang;

class BarangChart extends ChartWidget
{
    protected ?string $heading = 'Pergerakan Barang per Bulan';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;
    protected function getData(): array
    {
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = Barang::whereMonth('created_at', $i)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Barang',
                    'data' => $data,
                ],
            ],
            'labels' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
