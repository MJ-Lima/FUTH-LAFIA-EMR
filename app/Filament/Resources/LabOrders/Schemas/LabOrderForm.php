<?php

namespace App\Filament\Resources\LabOrders\Schemas;

use Filament\Forms\Components\DateTimePicker, Select, TextInput, Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class LabOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('LabOrder Details')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('patient_id')->label('Patient')->required()->relationship('patient', 'full_name')->searchable()->preload(),
                            Select::make('encounter_id')->label('Encounter')->relationship('encounter', 'encounter_number')->searchable()->preload(),
                            Select::make('requested_by')->label('Requester')->required()->relationship('requested_by', 'name')->searchable()->preload(),
                            DateTimePicker::make('ordered_at')->label('Ordered At')->required(),
                            Select::make('priority')->label('Priority')->required()->options(['Routine' => 'Routine', 'Urgent' => 'Urgent', 'STAT' => 'STAT', 'ASAP' => 'ASAP'])->searchable(),
                            Select::make('status')->label('Status')->required()->options(['Pending' => 'Pending', 'Sample Collected' => 'Sample Collected', 'In Progress' => 'In Progress', 'Completed' => 'Completed', 'Verified' => 'Verified', 'Cancelled' => 'Cancelled', 'Rejected' => 'Rejected'])->searchable(),
                            Textarea::make('clinical_notes')->label('Clinical Notes'),
                            Textarea::make('specimen_source')->label('Specimen Source'),
                            TextInput::make('fasting_status')->label('Fasting Status'),
                        ]),
                    ]),
            ]);
    }
}
