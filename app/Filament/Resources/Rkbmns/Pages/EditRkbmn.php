<?php

namespace App\Filament\Resources\Rkbmns\Pages;

use App\Filament\Resources\Rkbmns\RkbmnResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRkbmn extends EditRecord
{
    protected static string $resource = RkbmnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
