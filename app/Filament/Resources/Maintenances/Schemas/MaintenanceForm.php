<?php

namespace App\Filament\Resources\Maintenances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MaintenanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'nama_barang')
                    ->searchable()
                    ->preload()
                    ->required()->getOptionLabelFromRecordUsing(
                        fn($record) =>
                        match ($record->kondisi) {
                            'Baik' => '🟢 ',
                            'Rusak Ringan' => '🟡 ',
                            'Rusak Berat' => '🔴 ',
                            default => '⚪ ',
                        } .
                            $record->kode_barang . ' - ' .
                            $record->nama_barang . ' - ' .
                            $record->nup . '- ' .
                            $record->merk
                    ),
                DatePicker::make('tanggal')
                    ->required(),
                Select::make('jenis')
                    ->options([
                        'Servis' => 'Servis',
                        'Perbaikan' => 'Perbaikan',
                        'Penghapusan' => 'Penghapusan'
                    ]),
                Textarea::make('deskripsi')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('biaya')
                    ->numeric()
                    ->default(null),
                Select::make('kondisi_setelah')
                    ->options(['Baik' => 'Baik', 'Rusak Ringan' => 'Rusak ringan', 'Rusak Berat' => 'Rusak berat', 'Dihapus' => 'Dihapus'])
                    ->required(),
            ]);
    }
}
