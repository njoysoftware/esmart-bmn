<?php

namespace App\Filament\Resources\Rkbmns;

use App\Filament\Resources\Rkbmns\Pages\CreateRkbmn;
use App\Filament\Resources\Rkbmns\Pages\EditRkbmn;
use App\Filament\Resources\Rkbmns\Pages\ListRkbmns;
use App\Filament\Resources\Rkbmns\Schemas\RkbmnForm;
use App\Filament\Resources\Rkbmns\Tables\RkbmnsTable;
use App\Models\Rkbmn;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RkbmnResource extends Resource
{
    protected static ?string $model = Rkbmn::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmark;

    protected static ?string $recordTitleAttribute = 'nama_barang.barang';

    public static function form(Schema $schema): Schema
    {
        return RkbmnForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RkbmnsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRkbmns::route('/'),
            'create' => CreateRkbmn::route('/create'),
            'edit' => EditRkbmn::route('/{record}/edit'),
        ];
    }
}
