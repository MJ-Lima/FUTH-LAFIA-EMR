<?php

namespace App\Filament\Resources\Prescriptions\Schemas;

use Filament\Schemas\Schema;

use App\Models\Drug;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;


class PrescriptionForm
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
                        Toggle::make('is_inpatient')
                            ->label('Inpatient')
                            ->inline(false),
                    ])->columns(3),

                Section::make('Prescriber')
                    ->schema([
                        Select::make('prescriber_id')
                            ->label('Prescriber')
                            ->relationship('prescriber', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('dispensing_point_id')
                            ->label('Dispensing point')
                            ->relationship('dispensingPoint', 'name')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),

                Section::make('Order')
                    ->schema([
                        DateTimePicker::make('prescribed_at')
                            ->label('Prescribed at')
                            ->default(now()),
                        Select::make('priority')
                            ->label('Priority')
                            ->options([
                                'Routine' => 'Routine',
                                'Urgent' => 'Urgent',
                                'STAT' => 'STAT',
                            ])
                            ->default('Routine')
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Pending' => 'Pending',
                                'Partially Dispensed' => 'Partially Dispensed',
                                'Dispensed' => 'Dispensed',
                                'Cancelled' => 'Cancelled',
                                'Rejected' => 'Rejected',
                            ])
                            ->default('Pending')
                            ->required(),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('Items')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('drug_id')
                                    ->label('Drug')
                                    ->relationship('drug', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $drug = Drug::find($state);
                                        if ($drug) {
                                            $set('drug_name', $drug->name);
                                            $set('dosage_form', $drug->dosage_form);
                                            $set('strength', $drug->strength);
                                        }
                                    }),
                                TextInput::make('drug_name')
                                    ->label('Drug name')
                                    ->disabled()
                                    ->dehydrated(),
                                TextInput::make('dosage_form')
                                    ->label('Dosage form')
                                    ->disabled()
                                    ->dehydrated(),
                                TextInput::make('strength')
                                    ->label('Strength')
                                    ->disabled()
                                    ->dehydrated(),
                                TextInput::make('dose')
                                    ->label('Dose')
                                    ->required()
                                    ->placeholder('e.g. 500mg or 1 tablet'),
                                Select::make('route')
                                    ->label('Route')
                                    ->options([
                                        'PO' => 'PO',
                                        'IV' => 'IV',
                                        'IM' => 'IM',
                                        'SC' => 'SC',
                                        'PR' => 'PR',
                                        'Topical' => 'Topical',
                                        'Inhalation' => 'Inhalation',
                                        'Sublingual' => 'Sublingual',
                                        'Ophthalmic' => 'Ophthalmic',
                                        'Otic' => 'Otic',
                                        'Nasal' => 'Nasal',
                                    ])
                                    ->default('PO'),
                                Select::make('frequency')
                                    ->label('Frequency')
                                    ->options([
                                        'OD' => 'OD',
                                        'BD' => 'BD',
                                        'TDS' => 'TDS',
                                        'QDS' => 'QDS',
                                        'Q4H' => 'Q4H',
                                        'Q6H' => 'Q6H',
                                        'Q8H' => 'Q8H',
                                        'Q12H' => 'Q12H',
                                        'QHS' => 'QHS',
                                        'PRN' => 'PRN',
                                        'Stat' => 'Stat',
                                    ]),
                                TextInput::make('duration')
                                    ->label('Duration')
                                    ->required()
                                    ->placeholder('e.g. 5 days, 2 weeks'),
                                TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1),
                                Textarea::make('instructions')
                                    ->label('Instructions')
                                    ->rows(2),
                                Select::make('status')
                                    ->label('Item status')
                                    ->options([
                                        'Pending' => 'Pending',
                                        'Partially Dispensed' => 'Partially Dispensed',
                                        'Dispensed' => 'Dispensed',
                                        'Cancelled' => 'Cancelled',
                                    ])
                                    ->default('Pending'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add medication'),
                    ]),
            ]);
    }
}
