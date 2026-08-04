<?php

namespace App\Filament\Resources\LabOrders\Schemas;

use Filament\Schemas\Schema;

use App\Models\LabTest;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

use Illuminate\Support\Facades\Auth;

class LabOrderForm
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
                    ])->columns(2),

                Section::make('Order details')
                    ->schema([
                        Select::make('priority')
                            ->label('Priority')
                            ->options([
                                'Routine' => 'Routine',
                                'Urgent' => 'Urgent',
                                'STAT' => 'STAT',
                                'ASAP' => 'ASAP',
                            ])
                            ->default('Routine')
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Pending' => 'Pending',
                                'Sample Collected' => 'Sample Collected',
                                'In Progress' => 'In Progress',
                                'Completed' => 'Completed',
                                'Verified' => 'Verified',
                                'Cancelled' => 'Cancelled',
                                'Rejected' => 'Rejected',
                            ])
                            ->default('Pending')
                            ->required(),
                        DateTimePicker::make('ordered_at')
                            ->label('Ordered at')
                            ->default(now()),
                        DateTimePicker::make('collected_at')
                            ->label('Collected at')
                            ->nullable(),
                        TextInput::make('specimen_source')
                            ->label('Specimen source')
                            ->maxLength(120),
                        TextInput::make('fasting_status')
                            ->label('Fasting status')
                            ->placeholder('e.g. Fasting / Random')
                            ->maxLength(64),
                        Textarea::make('clinical_notes')
                            ->label('Clinical notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Tests')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('lab_test_id')
                                    ->label('Lab test')
                                    ->relationship('test', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $test = LabTest::find($state);
                                        if ($test) {
                                            $set('test_name', $test->name);
                                            $set('loinc_code', $test->loinc_code);
                                            $set('price', $test->price);
                                        }
                                    }),
                                TextInput::make('test_name')
                                    ->label('Test name')
                                    ->disabled()
                                    ->dehydrated(),
                                TextInput::make('loinc_code')
                                    ->label('LOINC')
                                    ->disabled()
                                    ->dehydrated(),
                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(),
                                Select::make('status')
                                    ->label('Item status')
                                    ->options([
                                        'Pending' => 'Pending',
                                        'Collected' => 'Collected',
                                        'In Progress' => 'In Progress',
                                        'Completed' => 'Completed',
                                        'Verified' => 'Verified',
                                        'Cancelled' => 'Cancelled',
                                    ])
                                    ->default('Pending'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add test'),
                    ]),
            ]);
    }
}
