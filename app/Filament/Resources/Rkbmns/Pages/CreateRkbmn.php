<?php

namespace App\Filament\Resources\Rkbmns\Pages;

use App\Filament\Resources\Rkbmns\RkbmnResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRkbmn extends CreateRecord
{
    protected static string $resource = RkbmnResource::class;
    protected function getRedirectUrl(): string
    {
        return url('/admin/rkbmns');
    }
}
