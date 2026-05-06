<?php

namespace App\Filament\Resources\Rkbmns\Pages;

use App\Filament\Resources\Rkbmns\RkbmnResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRkbmns extends ListRecords
{
    protected static string $resource = RkbmnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
