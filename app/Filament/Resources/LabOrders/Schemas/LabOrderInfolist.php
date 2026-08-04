<?php

namespace App\Filament\Resources\LabOrders\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class LabOrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Header')
                    ->schema([
                        TextEntry::make('order_number')->label('Order #'),
                        TextEntry::make('priority')
                            ->label('Priority')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'STAT' => 'danger',
                                'ASAP' => 'danger',
                                'Urgent' => 'warning',
                                default => 'gray',
                            }),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Pending' => 'gray',
                                'Sample Collected' => 'info',
                                'In Progress' => 'warning',
                                'Completed' => 'success',
                                'Verified' => 'success',
                                'Cancelled' => 'danger',
                                'Rejected' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('ordered_at')->label('Ordered at')->dateTime(),
                        TextEntry::make('collected_at')->label('Collected at')->dateTime(),
                        TextEntry::make('resulted_at')->label('Resulted at')->dateTime(),
                        TextEntry::make('specimen_source')->label('Specimen source'),
                        TextEntry::make('fasting_status')->label('Fasting status'),
                        TextEntry::make('requester.name')->label('Requester'),
                        TextEntry::make('clinical_notes')->label('Clinical notes')->columnSpanFull(),
                    ])->columns(3),

                Section::make('Patient')
                    ->schema([
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('patient.patientcode')->label('Patient code'),
                        TextEntry::make('encounter.encounter_number')->label('Encounter'),
                    ])->columns(3),

                Section::make('Tests')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('Ordered tests')
                            ->schema([
                                TextEntry::make('test_name')->label('Test'),
                                TextEntry::make('loinc_code')->label('LOINC'),
                                TextEntry::make('price')->label('Price')->money('NGN'),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Pending' => 'gray',
                                        'Collected' => 'info',
                                        'In Progress' => 'warning',
                                        'Completed' => 'success',
                                        'Verified' => 'success',
                                        'Cancelled' => 'danger',
                                        default => 'gray',
                                    }),
                            ])
                            ->columns(4),
                    ]),

                Section::make('Status Timeline')
                    ->schema([
                        TextEntry::make('ordered_at')->label('Ordered')->dateTime(),
                        TextEntry::make('collected_at')->label('Sample collected')->dateTime(),
                        TextEntry::make('resulted_at')->label('Resulted')->dateTime(),
                        TextEntry::make('created_at')->label('Record created')->dateTime(),
                        TextEntry::make('updated_at')->label('Last updated')->dateTime(),
                    ])->columns(3),
            ]);
    }
}
