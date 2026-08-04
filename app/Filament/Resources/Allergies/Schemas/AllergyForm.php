<?php

namespace App\Filament\Resources\Allergies\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;


class AllergyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient')
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
                    ])->columns(2),

                Section::make('Allergen')
                    ->schema([
                        TextInput::make('substance')
                            ->label('Substance')
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('code')
                            ->label('Code (e.g. RxNorm / SNOMED / ATC)')
                            ->maxLength(255),
                        Select::make('category')
                            ->label('Category')
                            ->options([
                                'Medication' => 'Medication',
                                'Food' => 'Food',
                                'Environment' => 'Environment',
                                'Biologic' => 'Biologic',
                                'Other' => 'Other',
                            ])
                            ->required()
                            ->default('Medication'),
                    ])->columns(3),

                Section::make('Reaction')
                    ->schema([
                        Select::make('criticality')
                            ->label('Criticality')
                            ->options([
                                'Low' => 'Low',
                                'High' => 'High',
                                'Unable to assess' => 'Unable to assess',
                            ])
                            ->default('Low')
                            ->required(),
                        Select::make('severity')
                            ->label('Severity')
                            ->options([
                                'Mild' => 'Mild',
                                'Moderate' => 'Moderate',
                                'Severe' => 'Severe',
                                'Fatal' => 'Fatal',
                            ])
                            ->default('Mild')
                            ->required(),
                        Select::make('reaction')
                            ->label('Reaction')
                            ->options([
                                'Rash' => 'Rash',
                                'Urticaria' => 'Urticaria',
                                'Anaphylaxis' => 'Anaphylaxis',
                                'Angioedema' => 'Angioedema',
                                'Bronchospasm' => 'Bronchospasm',
                                'GI upset' => 'GI upset',
                                'Hepatotoxicity' => 'Hepatotoxicity',
                                'Stevens-Johnson' => 'Stevens-Johnson',
                                'Other' => 'Other',
                            ]),
                        Textarea::make('reaction_description')
                            ->label('Reaction description')
                            ->rows(2),
                        DatePicker::make('onset_date')
                            ->label('Onset date'),
                    ])->columns(2),

                Section::make('Notes & Status')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Active' => 'Active',
                                'Resolved' => 'Resolved',
                                'Inactive' => 'Inactive',
                            ])
                            ->default('Active')
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
