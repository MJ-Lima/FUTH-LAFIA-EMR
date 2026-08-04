<?php

namespace App\Filament\Resources\Vitals\Schemas;

use Filament\Schemas\Schema;


use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class VitalsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient & Encounter')
                    ->schema([
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('patient.patientcode')->label('Patient code'),
                        TextEntry::make('encounter.encounter_number')->label('Encounter'),
                        TextEntry::make('recorder.name')->label('Recorded by'),
                        TextEntry::make('recorded_at')->label('Recorded at')->dateTime(),
                    ])->columns(3),

                Section::make('Anthropometric')
                    ->schema([
                        TextEntry::make('height_cm')->label('Height')->suffix(' cm'),
                        TextEntry::make('weight_kg')->label('Weight')->suffix(' kg'),
                        TextEntry::make('bmi')->label('BMI'),
                        TextEntry::make('muac_cm')->label('MUAC')->suffix(' cm'),
                    ])->columns(4),

                Section::make('Cardiovascular')
                    ->schema([
                        TextEntry::make('bp')->label('Blood pressure'),
                        TextEntry::make('bp_position')->label('BP position'),
                        TextEntry::make('heart_rate')->label('Heart rate')->suffix(' bpm'),
                    ])->columns(3),

                Section::make('Respiratory')
                    ->schema([
                        TextEntry::make('respiratory_rate')->label('Respiratory rate')->suffix(' /min'),
                        TextEntry::make('spo2')->label('SpO₂')->suffix(' %'),
                    ])->columns(2),

                Section::make('Thermoregulation')
                    ->schema([
                        TextEntry::make('temperature_c')->label('Temperature')->suffix(' °C'),
                        TextEntry::make('temperature_route')->label('Route'),
                    ])->columns(2),

                Section::make('Neurological')
                    ->schema([
                        TextEntry::make('pain_score')->label('Pain score (0–10)'),
                        TextEntry::make('glasgow_coma_score')->label('Glasgow Coma Score'),
                    ])->columns(2),

                Section::make('Glucose')
                    ->schema([
                        TextEntry::make('blood_glucose_mmol_l')->label('Blood glucose')->suffix(' mmol/L'),
                        TextEntry::make('glucose_fasting')
                            ->label('Fasting sample')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),
                    ])->columns(2),

                Section::make('Maternal')
                    ->schema([
                        TextEntry::make('fetal_heart_rate')->label('Fetal heart rate')->suffix(' bpm'),
                        TextEntry::make('fundal_height_cm')->label('Fundal height')->suffix(' cm'),
                    ])->columns(2),

                Section::make('Notes')
                    ->schema([
                        TextEntry::make('notes')->columnSpanFull(),
                    ]),
            ]);
    }
}
