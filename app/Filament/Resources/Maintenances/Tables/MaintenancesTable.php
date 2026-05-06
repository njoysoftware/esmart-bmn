<?php

namespace App\Filament\Resources\Maintenances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;

class MaintenancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barang.nama_barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('jenis')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('biaya')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('kondisi_setelah')
                    ->sortable()
                    ->colors([
                        'success' => 'Baik',
                        'warning' => 'Rusak Ringan',
                        'danger' => 'Rusak Berat',
                        'default' => 'Dihapus',
                    ])
                    ->searchable(),
            ])
            ->filters([
                //
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
