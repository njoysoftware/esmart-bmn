<?php

namespace App\Filament\Resources\Lokasis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Lokasi;

class LokasisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_ruang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama_ruang')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('id')
                    ->label('Lokasi')
                    ->options(
                        Lokasi::orderBy('kode_ruang')
                            ->get()
                            ->mapWithKeys(fn($item) => [
                                $item->id => $item->kode_ruang . ' - ' . $item->nama_ruang
                            ])
                    )
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
