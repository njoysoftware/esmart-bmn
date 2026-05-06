<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('password')
                    ->columnSpanFull()
                    ->password()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->columnSpanFull()
                    ->email()
                    ->required(),
                Select::make('role')
                    ->columnSpanFull()
                    ->options(['admin' => 'Admin', 'user' => 'User'])
                    ->required(),
            ]);
    }
}
