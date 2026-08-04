<?php

namespace App\Filament\Resources\Vitals\Schemas;

use Filament\Schemas\Schema;


use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;


class VitalsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient & Encounter')
                    ->schema([
                        Select::make('patient_id')
                            ->label('Patient')
                            ->relationship('patient', 'patientcode')
                            ->getOptionLabelUsing(fn ($record) => $record?->patient?->full_name . ' (' . $record?->patient?->patientcode . ')')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('encounter_id')
                            ->label('Encounter')
                            ->relationship('encounter', 'encounter_number')
                            ->searchable()
                            ->preload(),
                        DateTimePicker::make('recorded_at')
                            ->label('Recorded at')
                            ->default(now())
                            ->required(),
                    ])->columns(3),

                Section::make('Anthropometric')
                    ->schema([
                        TextInput::make('height_cm')
                            ->label('Height (cm)')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(300),
                        TextInput::make('weight_kg')
                            ->label('Weight (kg)')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(500),
                        TextInput::make('muac_cm')
                            ->label('MUAC (cm)')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('bmi')
                            ->label('BMI')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Auto-computed from height & weight on save.'),
                    ])->columns(4),

                Section::make('Cardiovascular')
                    ->schema([
                        TextInput::make('systolic_bp')
                            ->label('Systolic BP (mmHg)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(300),
                        TextInput::make('diastolic_bp')
                            ->label('Diastolic BP (mmHg)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(200),
                        Select::make('bp_position')
                            ->label('BP position')
                            ->options([
                                'Sitting' => 'Sitting',
                                'Standing' => 'Standing',
                                'Lying' => 'Lying',
                            ]),
                        TextInput::make('heart_rate')
                            ->label('Heart rate (bpm)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(300),
                    ])->columns(4),

                Section::make('Respiratory')
                    ->schema([
                        TextInput::make('respiratory_rate')
                            ->label('Respiratory rate (/min)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('spo2')
                            ->label('SpO₂ (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                    ])->columns(2),

                Section::make('Thermoregulation')
                    ->schema([
                        TextInput::make('temperature_c')
                            ->label('Temperature (°C)')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(20)
                            ->maxValue(50),
                        Select::make('temperature_route')
                            ->label('Route')
                            ->options([
                                'Oral' => 'Oral',
                                'Axillary' => 'Axillary',
                                'Tympanic' => 'Tympanic',
                                'Rectal' => 'Rectal',
                                'Forehead' => 'Forehead',
                            ]),
                    ])->columns(2),

                Section::make('Neurological')
                    ->schema([
                        TextInput::make('pain_score')
                            ->label('Pain score (0–10)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(10),
                        TextInput::make('glasgow_coma_score')
                            ->label('Glasgow Coma Score (3–15)')
                            ->numeric()
                            ->minValue(3)
                            ->maxValue(15),
                    ])->columns(2),

                Section::make('Glucose')
                    ->schema([
                        TextInput::make('blood_glucose_mmol_l')
                            ->label('Blood glucose (mmol/L)')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(60),
                        Toggle::make('glucose_fasting')
                            ->label('Fasting sample')
                            ->default(false),
                    ])->columns(2),

                Section::make('Maternal (optional)')
                    ->schema([
                        TextInput::make('fetal_heart_rate')
                            ->label('Fetal heart rate (bpm)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(250),
                        TextInput::make('fundal_height_cm')
                            ->label('Fundal height (cm)')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(60),
                    ])->columns(2),

                Section::make('Notes')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3),
                    ])->columns(1),
            ]);
    }
}
