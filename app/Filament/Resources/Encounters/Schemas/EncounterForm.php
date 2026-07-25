<?php

namespace App\Filament\Resources\Encounters\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class EncounterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('hospital_id')
                    ->required()
                    ->numeric(),
                TextInput::make('patient_id')
                    ->required()
                    ->numeric(),
                TextInput::make('clinic_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('encounter_number')
                    ->required(),
                Select::make('visit_type')
                    ->options([
            'Outpatient' => 'Outpatient',
            'Emergency' => 'Emergency',
            'Inpatient' => 'Inpatient',
            'Telemedicine' => 'Telemedicine',
            'Follow-up' => 'Follow up',
        ])
                    ->required(),
                DatePicker::make('encounter_date')
                    ->required(),
                TimePicker::make('encounter_time')
                    ->required(),
                Select::make('status')
                    ->options([
            'Waiting' => 'Waiting',
            'In Progress' => 'In progress',
            'Completed' => 'Completed',
            'Cancelled' => 'Cancelled',
        ])
                    ->default('Waiting')
                    ->required(),
                Textarea::make('chief_complaint')
                    ->columnSpanFull(),
                TextInput::make('referred_by'),
                TextInput::make('appointment_id')
                    ->numeric(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
