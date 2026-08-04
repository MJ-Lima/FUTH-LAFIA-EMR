<?php

namespace App\Filament\Resources\DrugBatches\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;


class DrugBatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Batch Information')
                    ->schema([
                        Select::make('drug_id')
                            ->label('Drug')
                            ->relationship('drug', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('batch_number')
                            ->label('Batch number')
                            ->required()
                            ->maxLength(120),
                        DatePicker::make('expiry_date')
                            ->label('Expiry date')
                            ->required(),
                        DatePicker::make('manufactured_date')
                            ->label('Manufactured date'),
                    ])->columns(2),

                Section::make('Quantity')
                    ->schema([
                        TextInput::make('quantity_received')
                            ->label('Quantity received')
                            ->numeric()
                            ->step(0.01)
                            ->default(0),
                        TextInput::make('quantity_remaining')
                            ->label('Quantity remaining')
                            ->numeric()
                            ->step(0.01)
                            ->default(0),
                        TextInput::make('cost_price')
                            ->label('Cost price (per unit)')
                            ->numeric()
                            ->prefix('NGN')
                            ->step(0.01)
                            ->default(0),
                    ])->columns(3),

                Section::make('Supplier')
                    ->schema([
                        TextInput::make('supplier')
                            ->label('Supplier')
                            ->maxLength(150),
                        DatePicker::make('received_date')
                            ->label('Received date'),
                        Toggle::make('is_quarantined')
                            ->label('Quarantined')
                            ->default(false),
                    ])->columns(3),
            ]);
    }
}
