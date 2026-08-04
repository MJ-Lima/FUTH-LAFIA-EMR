<?php

namespace App\Filament\Resources\ClinicalNotes\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;


class ClinicalNoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Note Information')
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
                        Select::make('note_type')
                            ->options([
                                'Progress' => 'Progress',
                                'Admission' => 'Admission',
                                'Discharge' => 'Discharge',
                                'Nursing' => 'Nursing',
                                'Procedure' => 'Procedure',
                                'Consultation' => 'Consultation',
                                'Referral' => 'Referral',
                                'Death' => 'Death',
                                'Other' => 'Other',
                            ])
                            ->required()
                            ->default('Progress'),
                        TextInput::make('title')->maxLength(255),
                    ])->columns(2),

                Section::make('SOAP Note')
                    ->schema([
                        Textarea::make('subjective')
                            ->label('S — Subjective')
                            ->rows(3)
                            ->placeholder('Patient-reported symptoms, history of presenting complaint…'),
                        Textarea::make('objective')
                            ->label('O — Objective')
                            ->rows(3)
                            ->placeholder('Examination findings, observed vitals…'),
                        Textarea::make('assessment')
                            ->label('A — Assessment')
                            ->rows(3)
                            ->placeholder('Diagnosis / clinical impression…'),
                        Textarea::make('plan')
                            ->label('P — Plan')
                            ->rows(3)
                            ->placeholder('Treatment plan, orders, follow-up…'),
                    ]),

                Section::make('Narrative')
                    ->schema([
                        Textarea::make('narrative')
                            ->rows(4)
                            ->placeholder('Free-form narrative note (optional)'),
                    ]),

                Section::make('Signing')
                    ->schema([
                        Toggle::make('is_signed')
                            ->label('Sign this note (locks editing)')
                            ->helperText('Once signed, the note becomes part of the legal medical record.'),
                    ]),
            ]);
    }
}
