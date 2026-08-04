<?php

namespace App\Filament\Resources\RadiologyModalities\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;


class RadiologyModalityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Modality Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Modality name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('code')
                            ->label('Modality code')
                            ->required()
                            ->maxLength(64)
                            ->unique('radiology_modalities', 'code', ignoreRecord: true)
                            ->helperText('e.g. XRAY, CT, MR, US, NM, PT — must be unique.'),
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(0.01),
                        TextInput::make('turnaround_hours')
                            ->label('Turnaround (hours)')
                            ->numeric()
                            ->default(24)
                            ->minValue(0),
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
