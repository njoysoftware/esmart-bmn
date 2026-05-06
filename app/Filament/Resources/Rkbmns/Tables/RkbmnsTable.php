<?php

namespace App\Filament\Resources\Rkbmns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;
use Filament\Tables\Filters\SelectFilter;

class RkbmnsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barang.nama_barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jenis_rekomendasi')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('prioritas')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tahun'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('prioritas')
                    ->options([
                        'Pengadaan' => 'Pengadaan',
                        'Penggantian' => 'Penggantian',
                        'Penghapusan' => 'Penghapusan',
                    ]),
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
