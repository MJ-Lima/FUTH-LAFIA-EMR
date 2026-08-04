<?php

namespace App\Filament\Resources\Allergies\Schemas;

use Filament\Schemas\Schema; 
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class AllergyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient')
                    ->schema([
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('patient.patientcode')->label('Patient code'),
                        TextEntry::make('encounter.encounter_number')->label('Encounter'),
                        TextEntry::make('recorder.name')->label('Recorded by'),
                    ])->columns(2),

                Section::make('Allergen')
                    ->schema([
                        TextEntry::make('substance')->label('Substance'),
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('category')->label('Category')->badge(),
                    ])->columns(3),

                Section::make('Reaction')
                    ->schema([
                        TextEntry::make('criticality')
                            ->label('Criticality')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'High' => 'danger',
                                'Low' => 'gray',
                                'Unable to assess' => 'warning',
                                default => 'gray',
                            }),
                        TextEntry::make('severity')
                            ->label('Severity')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Fatal' => 'danger',
                                'Severe' => 'danger',
                                'Moderate' => 'warning',
                                'Mild' => 'gray',
                                default => 'gray',
                            }),
                        TextEntry::make('reaction')->label('Reaction'),
                        TextEntry::make('reaction_description')
                            ->label('Reaction description')
                            ->columnSpanFull(),
                        TextEntry::make('onset_date')->label('Onset date')->date(),
                    ])->columns(3),

                Section::make('Notes & Status')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Active' => 'success',
                                'Resolved' => 'gray',
                                'Inactive' => 'warning',
                                default => 'gray',
                            }),
                        TextEntry::make('notes')->label('Notes')->columnSpanFull(),
                        TextEntry::make('created_at')->label('Created at')->dateTime(),
                        TextEntry::make('updated_at')->label('Updated at')->dateTime(),
                    ])->columns(2),
            ]);
    }
}
