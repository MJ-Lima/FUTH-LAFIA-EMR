<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;


class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Supplier Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(150),
                        TextInput::make('code')
                            ->label('Code')
                            ->maxLength(32),
                        TextInput::make('contact_person')
                            ->label('Contact person')
                            ->maxLength(120),
                        TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(32),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(120),
                    ])->columns(2),

                Section::make('Address & Compliance')
                    ->schema([
                        Textarea::make('address')
                            ->label('Address')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('tax_id')
                            ->label('Tax ID')
                            ->maxLength(64),
                        TextInput::make('registration_number')
                            ->label('Registration number')
                            ->maxLength(64),
                    ])->columns(2),

                Section::make('Status')
                    ->schema([
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true),
                    ])->columns(1),
            ]);
    }
}
