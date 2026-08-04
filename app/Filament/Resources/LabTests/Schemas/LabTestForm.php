<?php

namespace App\Filament\Resources\LabTests\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

use Illuminate\Support\Facades\Auth;

class LabTestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Test Information')
                    ->schema([
                        TextInput::make('hospital_id')
                            ->hidden()
                            ->default(fn () => Auth::user()?->hospital_id)
                            ->dehydrated(),
                        Select::make('lab_panel_id')
                            ->label('Lab panel')
                            ->relationship('panel', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        TextInput::make('name')
                            ->label('Test name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('code')
                            ->label('Test code')
                            ->required()
                            ->maxLength(64)
                            ->unique('lab_tests', 'code', ignoreRecord: true)
                            ->helperText('Must be unique across all lab tests.'),
                        TextInput::make('loinc_code')
                            ->label('LOINC code')
                            ->maxLength(64),
                    ])->columns(2),

                Section::make('Specimen & Container')
                    ->schema([
                        TextInput::make('specimen_type')
                            ->label('Specimen type')
                            ->maxLength(120),
                        TextInput::make('container')
                            ->label('Container')
                            ->maxLength(120),
                        TextInput::make('unit')
                            ->label('Reporting unit')
                            ->maxLength(64),
                    ])->columns(3),

                Section::make('Reference Range')
                    ->schema([
                        TextInput::make('reference_range_low')
                            ->label('Lower bound')
                            ->numeric()
                            ->step(0.0001),
                        TextInput::make('reference_range_high')
                            ->label('Upper bound')
                            ->numeric()
                            ->step(0.0001),
                        Textarea::make('reference_notes')
                            ->label('Reference notes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Pricing & Turnaround')
                    ->schema([
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
                    ])->columns(3),

                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(1),
            ]);
    }
}
