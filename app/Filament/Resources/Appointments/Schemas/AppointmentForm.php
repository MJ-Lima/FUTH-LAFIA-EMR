<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Schemas\Schema;

use App\Models\Clinic;
use App\Models\Patient;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;

use Illuminate\Support\Facades\Auth;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient & Clinic')
                    ->schema([
                        Select::make('patient_id')
                            ->label('Patient')
                            ->relationship('patient', 'patientcode')
                            ->getOptionLabelUsing(fn ($record) => $record?->patient?->full_name . ' (' . $record?->patient?->patientcode . ')')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('clinic_id')
                            ->label('Clinic')
                            ->relationship('clinic', 'name', fn ($query) => $query->where('hospital_id', Auth::user()?->hospital_id)->orderBy('name'))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('provider_id')
                            ->label('Provider (Doctor)')
                            ->relationship('provider', 'name')
                            ->searchable()
                            ->preload(),
                    ])->columns(3),

                Section::make('Appointment Details')
                    ->schema([
                        DatePicker::make('appointment_date')
                            ->label('Date')
                            ->required()
                            ->minDate(today()),
                        TimePicker::make('appointment_time')
                            ->label('Time')
                            ->required(),
                        TextInput::make('estimated_duration')
                            ->label('Estimated duration (minutes)')
                            ->numeric()
                            ->default(30)
                            ->minValue(5)
                            ->maxValue(480),
                        Select::make('visit_type')
                            ->label('Visit type')
                            ->options([
                                'New' => 'New',
                                'Follow-up' => 'Follow-up',
                                'Review' => 'Review',
                                'Telemedicine' => 'Telemedicine',
                            ])
                            ->required(),
                        Select::make('priority')
                            ->label('Priority')
                            ->options([
                                'Routine' => 'Routine',
                                'Urgent' => 'Urgent',
                                'Emergency' => 'Emergency',
                            ])
                            ->default('Routine')
                            ->required(),
                    ])->columns(3),

                Section::make('Reason & Notes')
                    ->schema([
                        Textarea::make('reason_for_visit')
                            ->label('Reason for visit')
                            ->rows(2)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(2),
                        Textarea::make('cancellation_reason')
                            ->label('Cancellation reason')
                            ->rows(2)
                            ->visible(fn ($record) => $record?->status === 'Cancelled'),
                    ])->columns(1),
            ]);
    }
}
