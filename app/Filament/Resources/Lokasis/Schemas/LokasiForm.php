<?php

namespace App\Filament\Resources\Lokasis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LokasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_ruang')
                    ->required(),
                TextInput::make('nama_ruang')
                    ->required(),
            ]);
    }
}
