<?php

namespace App\Filament\Resources\ClinicalNotes\Schemas;
use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class ClinicalNoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Note')
                    ->schema([
                        TextEntry::make('note_number')->label('Note #'),
                        TextEntry::make('note_type')->badge(),
                        TextEntry::make('title'),
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('encounter.encounter_number')->label('Encounter'),
                        TextEntry::make('author.name')->label('Author'),
                        TextEntry::make('is_signed')->label('Signed')->badge(),
                        TextEntry::make('signed_at')->dateTime(),
                        TextEntry::make('signedBy.name')->label('Signed by'),
                    ])->columns(3),

                Section::make('SOAP')
                    ->schema([
                        TextEntry::make('subjective')->label('S — Subjective')->columnSpanFull(),
                        TextEntry::make('objective')->label('O — Objective')->columnSpanFull(),
                        TextEntry::make('assessment')->label('A — Assessment')->columnSpanFull(),
                        TextEntry::make('plan')->label('P — Plan')->columnSpanFull(),
                    ]),

                Section::make('Narrative')
                    ->schema([
                        TextEntry::make('narrative')->columnSpanFull(),
                    ]),
            ]);
    }
}
