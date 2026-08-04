<?php

namespace App\Filament\Resources\DispensingPoints\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;


class DispensingPointForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dispensing Point')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(120)
                            ->placeholder('e.g. Main Pharmacy'),
                        TextInput::make('code')
                            ->label('Code')
                            ->required()
                            ->maxLength(64)
                            ->placeholder('e.g. MAIN-PHARM'),
                        TextInput::make('location')
                            ->label('Location')
                            ->maxLength(180)
                            ->placeholder('e.g. Ground floor, Block A'),
                        Select::make('in_charge_id')
                            ->label('In-charge')
                            ->relationship('inCharge', 'name')
                            ->searchable()
                            ->preload(),
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                    ])->columns(2),
            ]);
    }
}
