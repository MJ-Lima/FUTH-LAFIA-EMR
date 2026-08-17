<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(),
				Select::make('roles')
					->relationship('roles', 'name')
					->multiple()
					->preload()
					->searchable(),
				Select::make('hospital_id')
                    ->relationship('hospital', 'name')
					 ->label('Hospital')
                    ->required(),
				Select::make('department_id')
                    ->relationship('department', 'name')
					 ->label('Department')
                    ->required(),
            ]);
    }
}
