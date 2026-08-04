<?php

namespace App\Filament\Resources\DispensingLogs\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class DispensingLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dispensing')
                    ->schema([
                        TextEntry::make('reference_number')->label('Reference #'),
                        TextEntry::make('dispensed_at')->label('Dispensed at')->dateTime(),
                        TextEntry::make('dispensingPoint.name')->label('Dispensing point'),
                        TextEntry::make('dispenser.name')->label('Dispensed by'),
                    ])->columns(2),

                Section::make('Patient & Prescription')
                    ->schema([
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('patient.patientcode')->label('Patient code'),
                        TextEntry::make('prescription.prescription_number')->label('Prescription'),
                        TextEntry::make('prescriptionItem.drug_name')->label('Prescription item'),
                    ])->columns(2),

                Section::make('Drug & Batch')
                    ->schema([
                        TextEntry::make('drug.name')->label('Drug'),
                        TextEntry::make('batch.batch_number')->label('Batch'),
                    ])->columns(2),

                Section::make('Quantity & Pricing')
                    ->schema([
                        TextEntry::make('quantity')->label('Quantity'),
                        TextEntry::make('unit_price')->label('Unit price')->money('NGN'),
                        TextEntry::make('total_price')->label('Total price')->money('NGN'),
                        TextEntry::make('notes')->label('Notes')->columnSpanFull(),
                    ])->columns(3),
            ]);
    }
}
