<?php

namespace App\Filament\Resources\RadiologyOrders\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;


class RadiologyOrderForm
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

                Section::make('Examination')
                    ->schema([
                        Select::make('modality_id')
                            ->label('Modality')
                            ->relationship('modality', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('examination')
                            ->label('Examination')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Chest X-Ray PA view'),
                        TextInput::make('body_part')
                            ->label('Body part')
                            ->maxLength(120)
                            ->placeholder('e.g. Chest'),
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
                                'Scheduled' => 'Scheduled',
                                'In Progress' => 'In Progress',
                                'Completed' => 'Completed',
                                'Verified' => 'Verified',
                                'Cancelled' => 'Cancelled',
                            ])
                            ->default('Pending')
                            ->required(),
                    ])->columns(2),

                Section::make('Clinical Info')
                    ->schema([
                        Textarea::make('clinical_indication')
                            ->label('Clinical indication')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('request_notes')
                            ->label('Request notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(1),

                Section::make('Timestamps')
                    ->schema([
                        DateTimePicker::make('ordered_at')
                            ->label('Ordered at')
                            ->default(now()),
                        DateTimePicker::make('performed_at')
                            ->label('Performed at')
                            ->nullable(),
                    ])->columns(2),
            ]);
    }
}
