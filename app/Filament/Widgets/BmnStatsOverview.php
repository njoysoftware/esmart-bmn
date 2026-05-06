<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Barang;
use App\Models\Maintenance;
use Carbon\Carbon;

class BmnStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        $bulanIni = Barang::whereMonth('created_at', now()->month)->count();
        $bulanLalu = Barang::whereMonth('created_at', now()->subMonth()->month)->count();

        $persen = $bulanLalu > 0
            ? (($bulanIni - $bulanLalu) / $bulanLalu) * 100
            : 100;

        return [
            Stat::make('Total Barang', Barang::count())
                ->description($this->trendText($persen))
                ->descriptionIcon($persen >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($persen >= 0 ? 'success' : 'danger'),

            Stat::make('Barang Baik', Barang::where('kondisi', 'baik')->count())
                ->description('Kondisi normal')
                ->color('success'),

            Stat::make('Rusak Ringan', Barang::where('kondisi', 'rusak ringan')->count())
                ->description('Perlu perbaikan')
                ->color('warning'),

            Stat::make('Rusak Berat', Barang::where('kondisi', 'rusak berat')->count())
                ->description('Perlu penanganan Khusus')
                ->color('danger'),

            Stat::make('Maintenance', Maintenance::count())
                ->description('Total perbaikan tercatat' . $this->trendText($persen))
                ->descriptionIcon($persen >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($persen >= 0 ? 'success' : 'danger'),
        ];
    }

    private function trendText($persen): string
    {
        if ($persen > 0) {
            return '+' . number_format($persen, 1) . '% dari bulan lalu';
        }

        if ($persen < 0) {
            return number_format($persen, 1) . '% dari bulan lalu';
        }

        return 'Stabil dari bulan lalu';
    }
}
