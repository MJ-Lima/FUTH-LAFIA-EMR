<?php

namespace App\Filament\Resources\Drugs\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

use Illuminate\Support\Facades\Auth;

class DrugForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Drug Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Brand name')
                            ->required()
                            ->maxLength(150),
                        TextInput::make('generic_name')
                            ->label('Generic name')
                            ->maxLength(150),
                        TextInput::make('code')
                            ->label('Code')
                            ->required()
                            ->maxLength(64),
                        TextInput::make('atc_code')
                            ->label('ATC code')
                            ->maxLength(32)
                            ->helperText('WHO Anatomical Therapeutic Chemical classification code'),
                        Select::make('drug_category_id')
                            ->label('Category')
                            ->relationship('category', 'name', fn ($query) => $query->orderBy('name'))
                            ->searchable()
                            ->preload(),
                    ])->columns(2),

                Section::make('Formulation')
                    ->schema([
                        TextInput::make('dosage_form')
                            ->label('Dosage form')
                            ->placeholder('e.g. Tablet, Capsule, Syrup, Injection')
                            ->maxLength(64),
                        TextInput::make('strength')
                            ->label('Strength')
                            ->placeholder('e.g. 500 mg')
                            ->maxLength(64),
                        TextInput::make('unit_of_measure')
                            ->label('Unit of measure')
                            ->placeholder('e.g. tablet, ml, vial')
                            ->maxLength(32),
                        TextInput::make('manufacturer')
                            ->label('Manufacturer')
                            ->maxLength(120),
                        TextInput::make('supplier')
                            ->label('Supplier (text)')
                            ->maxLength(120),
                    ])->columns(2),

                Section::make('Pricing & Stock')
                    ->schema([
                        TextInput::make('cost_price')
                            ->label('Cost price')
                            ->numeric()
                            ->prefix('NGN')
                            ->step(0.01)
                            ->default(0),
                        TextInput::make('selling_price')
                            ->label('Selling price')
                            ->numeric()
                            ->prefix('NGN')
                            ->step(0.01)
                            ->default(0),
                        TextInput::make('reorder_level')
                            ->label('Reorder level')
                            ->numeric()
                            ->step(0.01)
                            ->default(0),
                        TextInput::make('reorder_quantity')
                            ->label('Reorder quantity')
                            ->numeric()
                            ->step(0.01)
                            ->default(0),
                    ])->columns(2),

                Section::make('Safety Flags')
                    ->schema([
                        Toggle::make('is_controlled')
                            ->label('Controlled substance'),
                        Toggle::make('is_antenatal_safe')
                            ->label('Safe in pregnancy'),
                        Toggle::make('is_pediatric_safe')
                            ->label('Pediatric safe'),
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
