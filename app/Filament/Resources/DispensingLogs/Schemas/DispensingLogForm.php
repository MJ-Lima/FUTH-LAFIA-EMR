<?php

namespace App\Filament\Resources\DispensingLogs\Schemas;

use Filament\Schemas\Schema;

use App\Models\Drug;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;


class DispensingLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient & Prescription')
                    ->schema([
                        Select::make('patient_id')
                            ->label('Patient')
                            ->relationship('patient', 'patientcode')
                            ->getOptionLabelUsing(fn ($record) => $record?->patient?->full_name . ' (' . $record?->patient?->patientcode . ')')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('prescription_id')
                            ->label('Prescription')
                            ->relationship('prescription', 'prescription_number')
                            ->searchable()
                            ->preload(),
                        Select::make('prescription_item_id')
                            ->label('Prescription item')
                            ->relationship('prescriptionItem', 'drug_name')
                            ->searchable()
                            ->preload(),
                        Select::make('dispensing_point_id')
                            ->label('Dispensing point')
                            ->relationship('dispensingPoint', 'name')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),

                Section::make('Drug')
                    ->schema([
                        Select::make('drug_id')
                            ->label('Drug')
                            ->relationship('drug', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                $drug = Drug::find($state);
                                if ($drug) {
                                    $set('unit_price', $drug->selling_price);
                                }
                            }),
                        Select::make('drug_batch_id')
                            ->label('Batch')
                            ->relationship('batch', 'batch_number')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),

                Section::make('Quantity & Pricing')
                    ->schema([
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(0.01)
                            ->step(0.01)
                            ->live()
                            ->afterStateUpdated(function ($get, $set) {
                                $qty = (float) ($get('quantity') ?? 0);
                                $price = (float) ($get('unit_price') ?? 0);
                                $set('total_price', round($qty * $price, 2));
                            }),
                        TextInput::make('unit_price')
                            ->label('Unit price')
                            ->numeric()
                            ->prefix('NGN')
                            ->step(0.01)
                            ->live()
                            ->afterStateUpdated(function ($get, $set) {
                                $qty = (float) ($get('quantity') ?? 0);
                                $price = (float) ($get('unit_price') ?? 0);
                                $set('total_price', round($qty * $price, 2));
                            }),
                        TextInput::make('total_price')
                            ->label('Total price')
                            ->numeric()
                            ->prefix('NGN')
                            ->disabled()
                            ->dehydrated(),
                        DateTimePicker::make('dispensed_at')
                            ->label('Dispensed at')
                            ->default(now()),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
