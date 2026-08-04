<?php

namespace App\Filament\Resources\Prescriptions\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class PrescriptionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Prescription')
                    ->schema([
                        TextEntry::make('prescription_number')->label('Rx #'),
                        TextEntry::make('priority')
                            ->label('Priority')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'STAT' => 'danger',
                                'Urgent' => 'warning',
                                default => 'gray',
                            }),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Dispensed' => 'success',
                                'Partially Dispensed' => 'warning',
                                'Pending' => 'gray',
                                'Cancelled' => 'danger',
                                'Rejected' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('prescribed_at')->label('Prescribed at')->dateTime(),
                        TextEntry::make('dispensed_at')->label('Dispensed at')->dateTime(),
                        TextEntry::make('prescriber.name')->label('Prescriber'),
                        TextEntry::make('dispensingPoint.name')->label('Dispensing point'),
                        IconEntry::make('is_inpatient')->label('Inpatient')->boolean(),
                        TextEntry::make('notes')->label('Notes')->columnSpanFull(),
                    ])->columns(3),

                Section::make('Patient & Encounter')
                    ->schema([
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('patient.patientcode')->label('Patient code'),
                        TextEntry::make('encounter.encounter_number')->label('Encounter'),
                    ])->columns(3),

                Section::make('Items')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('Medications')
                            ->schema([
                                TextEntry::make('drug_name')->label('Drug'),
                                TextEntry::make('dose')->label('Dose'),
                                TextEntry::make('route')->label('Route'),
                                TextEntry::make('frequency')->label('Frequency'),
                                TextEntry::make('duration')->label('Duration'),
                                TextEntry::make('quantity')->label('Quantity'),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Dispensed' => 'success',
                                        'Partially Dispensed' => 'warning',
                                        'Pending' => 'gray',
                                        'Cancelled' => 'danger',
                                        default => 'gray',
                                    }),
                                TextEntry::make('instructions')->label('Instructions')->columnSpanFull(),
                            ])
                            ->columns(3),
                    ]),
            ]);
    }
}
