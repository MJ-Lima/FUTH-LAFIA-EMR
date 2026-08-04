<?php

namespace App\Filament\Resources\LabPanels\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;


class LabPanelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Panel Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Panel name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('code')
                            ->label('Panel code')
                            ->required()
                            ->maxLength(64)
                            ->unique('lab_panels', 'code', ignoreRecord: true)
                            ->helperText('Must be unique across all lab panels.'),
                        TextInput::make('loinc_code')
                            ->label('LOINC code')
                            ->maxLength(64),
                        TextInput::make('specimen_type')
                            ->label('Specimen type')
                            ->maxLength(120),
                        TextInput::make('container')
                            ->label('Container')
                            ->maxLength(120),
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
