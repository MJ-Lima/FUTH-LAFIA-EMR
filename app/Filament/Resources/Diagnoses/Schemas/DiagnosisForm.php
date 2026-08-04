<?php

namespace App\Filament\Resources\Diagnoses\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;


class DiagnosisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient')
                    ->schema([
                        Select::make('patient_id')
                            ->relationship('patient', 'patientcode')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('encounter_id')
                            ->relationship('encounter', 'encounter_number')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),
                Section::make('Diagnosis')
                    ->schema([
                        TextInput::make('icd10_code')
                            ->label('ICD-10 Code')
                            ->maxLength(10)
                            ->required()
                            ->placeholder('e.g. J00, E11.9, O00.0'),
                        TextInput::make('description')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->options([
                                'Principal' => 'Principal',
                                'Admitting' => 'Admitting',
                                'Working' => 'Working',
                                'Discharge' => 'Discharge',
                                'Secondary' => 'Secondary',
                                'Comorbidity' => 'Comorbidity',
                            ])
                            ->default('Working')
                            ->required(),
                        Select::make('status')
                            ->options([
                                'Active' => 'Active',
                                'Resolved' => 'Resolved',
                                'Chronic' => 'Chronic',
                                'Recurrent' => 'Recurrent',
                            ])
                            ->default('Active')
                            ->required(),
                        DatePicker::make('onset_date')->label('Onset date'),
                        DatePicker::make('resolved_date')->label('Resolved date'),
                        Textarea::make('notes')->rows(2),
                    ])->columns(2),
            ]);
    }
}
