<?php

namespace App\Filament\Resources\Allergies\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AllergyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Allergy Information')
                    ->schema([
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('substance')->label('Substance'),
                        TextEntry::make('category')->label('Category'),
                        TextEntry::make('severity')->label('Severity'),
                        TextEntry::make('reaction')->label('Reaction'),
                        TextEntry::make('status')->label('Status'),
                        TextEntry::make('onset_date')->label('Onset')->date(),
                    ])
                    ->columns(2),
            ]);
    }
}
