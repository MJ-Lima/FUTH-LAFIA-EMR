<?php

namespace App\Filament\Resources\StockReturns\Schemas;

use Filament\Schemas\Schema;


use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;


class StockReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Source')
                    ->schema([
                        Select::make('patient_id')
                            ->label('Patient')
                            ->relationship('patient', 'patientcode')
                            ->getOptionLabelUsing(fn ($record) => $record?->patient?->full_name . ' (' . $record?->patient?->patientcode . ')')
                            ->searchable()
                            ->preload(),
                        Select::make('dispensing_log_id')
                            ->label('Dispensing log')
                            ->relationship('dispensingLog', 'reference_number')
                            ->searchable()
                            ->preload(),
                        Select::make('drug_id')
                            ->label('Drug')
                            ->relationship('drug', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('drug_batch_id')
                            ->label('Batch')
                            ->relationship('batch', 'batch_number')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),

                Section::make('Return')
                    ->schema([
                        DateTimePicker::make('returned_at')
                            ->label('Returned at')
                            ->default(now()),
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->required()
                            ->minValue(0.01)
                            ->step(0.01)
                            ->default(1),
                        Select::make('reason')
                            ->label('Reason')
                            ->options([
                                'Expired' => 'Expired',
                                'Damaged' => 'Damaged',
                                'Wrong Dispense' => 'Wrong Dispense',
                                'Patient Returned' => 'Patient Returned',
                                'Other' => 'Other',
                            ])
                            ->default('Patient Returned')
                            ->required(),
                        Select::make('disposition')
                            ->label('Disposition')
                            ->options([
                                'Restocked' => 'Restocked',
                                'Quarantined' => 'Quarantined',
                                'Disposed' => 'Disposed',
                            ])
                            ->default('Quarantined')
                            ->required(),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
