<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Forms\Components\DatePicker, Select, TextInput, Textarea, TimePicker;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Appointment Details')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('patient_id')->label('Patient')->required()->relationship('patient', 'full_name')->searchable()->preload(),
                            Select::make('clinic_id')->label('Clinic')->required()->relationship('clinic', 'name')->searchable()->preload(),
                            Select::make('provider_id')->label('Provider')->relationship('provider', 'name')->searchable()->preload(),
                            DatePicker::make('appointment_date')->label('Date')->required(),
                            TimePicker::make('appointment_time')->label('Time')->required(),
                            TextInput::make('estimated_duration')->label('Est. Duration (min)')->numeric(),
                            Select::make('visit_type')->label('Visit Type')->required()->options(['New' => 'New', 'Follow-up' => 'Follow-up', 'Review' => 'Review', 'Telemedicine' => 'Telemedicine'])->searchable(),
                            Select::make('priority')->label('Priority')->required()->options(['Routine' => 'Routine', 'Urgent' => 'Urgent', 'Emergency' => 'Emergency'])->searchable(),
                            Textarea::make('reason_for_visit')->label('Reason for Visit')->required(),
                            Select::make('status')->label('Status')->required()->options(['Scheduled' => 'Scheduled', 'Confirmed' => 'Confirmed', 'Checked In' => 'Checked In', 'Completed' => 'Completed', 'Cancelled' => 'Cancelled', 'No Show' => 'No Show'])->searchable(),
                            Textarea::make('notes')->label('Notes'),
                            Textarea::make('cancellation_reason')->label('Cancellation Reason'),
                        ]),
                    ]),
            ]);
    }
}
