<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Facades\Filament;

class Laporan extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static ?string $navigationLabel = 'Laporan';
    protected static ?int $navigationSort = 10;
    protected string $view = 'filament.pages.laporan';

    public array $data = [];
    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function mount(): void
    {
        $this->form->fill([
            'tanggal_mulai' => now()->startOfMonth()->format('Y-m-d'),
            'tanggal_selesai' => now()->endOfMonth()->format('Y-m-d'),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('tanggal_mulai')
                ->required()
                ->native(false)
                ->displayFormat('d/m/Y')
                ->format('Y-m-d')
                ->live(),

            DatePicker::make('tanggal_selesai')
                ->required()
                ->native(false)
                ->displayFormat('d/m/Y')
                ->format('Y-m-d')
                ->live(),
        ];
    }
    protected function getHeaderActions(): array
    {
        return [

            Action::make('barang')
                ->label('Export Barang')
                ->url(fn() => $this->generateUrl('/laporan/barang'), true),

            Action::make('maintenance')
                ->label('Export Maintenance')
                ->url(fn() => $this->generateUrl('/laporan/maintenance'), true),

            Action::make('rkbmn')
                ->label('Export RKBMN')
                ->url(fn() => $this->generateUrl('/laporan/rkbmn'), true),

            Action::make('semua')
                ->label('Export Semua')
                ->color('success')
                ->url(fn() => $this->generateUrl('/laporan/semua'), true),
        ];
    }
    private function generateUrl(string $path): string
    {
        $data = $this->form->getState();

        return url($path . '?' . http_build_query([
            'start' => $data['tanggal_mulai'] ?? null,
            'end' => $data['tanggal_selesai'] ?? null,
        ]));
    }
    public static function canViewAny(): bool
    {
        return Filament::auth()->user()?->role === 'admin';
    }
}
