<?php

namespace App\Filament\Resources\RadiologyOrders\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class RadiologyOrderInfolist
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
                                'Urgent' => 'warning',
                                default => 'gray',
                            }),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Pending' => 'gray',
                                'Scheduled' => 'info',
                                'In Progress' => 'warning',
                                'Completed' => 'success',
                                'Verified' => 'success',
                                'Cancelled' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('ordered_at')->label('Ordered at')->dateTime(),
                        TextEntry::make('performed_at')->label('Performed at')->dateTime(),
                        TextEntry::make('resulted_at')->label('Resulted at')->dateTime(),
                        TextEntry::make('requester.name')->label('Requester'),
                        TextEntry::make('examination')->label('Examination'),
                        TextEntry::make('body_part')->label('Body part'),
                        TextEntry::make('clinical_indication')->label('Clinical indication')->columnSpanFull(),
                        TextEntry::make('request_notes')->label('Request notes')->columnSpanFull(),
                    ])->columns(3),

                Section::make('Patient')
                    ->schema([
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('patient.patientcode')->label('Patient code'),
                        TextEntry::make('encounter.encounter_number')->label('Encounter'),
                        TextEntry::make('modality.name')->label('Modality'),
                    ])->columns(4),

                Section::make('Status Timeline')
                    ->schema([
                        TextEntry::make('ordered_at')->label('Ordered')->dateTime(),
                        TextEntry::make('performed_at')->label('Performed')->dateTime(),
                        TextEntry::make('resulted_at')->label('Resulted')->dateTime(),
                        TextEntry::make('created_at')->label('Record created')->dateTime(),
                        TextEntry::make('updated_at')->label('Last updated')->dateTime(),
                    ])->columns(3),
            ]);
    }
}
