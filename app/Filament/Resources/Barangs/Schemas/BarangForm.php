<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;


class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_barang')
                    ->required(),
                TextInput::make('nup')
                    ->required(),
                Textarea::make('nama_barang')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('merk')
                    ->default(null),
                TextInput::make('kode_register')
                    ->default(null),
                Select::make('status_bmn')
                    ->options(['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif'])
                    ->required()
                    ->default('Aktif'),
                Select::make('lokasi_id')
                    ->relationship('lokasi', 'nama_ruang')
                    ->searchable()
                    ->preload(),
                Select::make('pegawai_id')
                    ->relationship('pegawai', 'nama')
                    ->searchable()
                    ->preload(),
                Select::make('kondisi')
                    ->options(['Baik' => 'Baik', 'Rusak Ringan' => 'Rusak ringan', 'Rusak Berat' => 'Rusak berat'])
                    ->default('Baik')
                    ->required(),
            ]);
    }
}
