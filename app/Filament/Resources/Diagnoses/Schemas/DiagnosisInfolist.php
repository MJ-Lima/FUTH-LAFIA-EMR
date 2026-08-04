<?php

namespace App\Filament\Resources\Diagnoses\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class DiagnosisInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Diagnosis')
                    ->schema([
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('patient.patientcode')->label('Code'),
                        TextEntry::make('icd10_code')->label('ICD-10'),
                        TextEntry::make('description')->columnSpanFull(),
                        TextEntry::make('type')->badge(),
                        TextEntry::make('status')->badge(),
                        TextEntry::make('onset_date')->date(),
                        TextEntry::make('resolved_date')->date(),
                        TextEntry::make('recorder.name')->label('Recorded by'),
                        TextEntry::make('notes')->columnSpanFull(),
                    ])->columns(3),
            ]);
    }
}
