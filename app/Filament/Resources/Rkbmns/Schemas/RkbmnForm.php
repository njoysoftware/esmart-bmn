<?php

namespace App\Filament\Resources\Rkbmns\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;


class RkbmnForm
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
                            $record->kondisi
                    ),

                Select::make('jenis_rekomendasi')
                    ->options([
                        'Pengadaan' => 'Pengadaan',
                        'Penggantian' => 'Penggantian',
                        'Penghapusan' => 'Penghapusan',
                    ])
                    ->required(),

                Textarea::make('alasan')
                    ->required(),

                Select::make('prioritas')
                    ->options([
                        'Tinggi' => 'Tinggi',
                        'Sedang' => 'Sedang',
                        'Rendah' => 'Rendah',
                    ])
                    ->required(),

                TextInput::make('tahun')
                    ->numeric()
                    ->default(date('Y'))
                    ->required(),
            ]);
    }
}
