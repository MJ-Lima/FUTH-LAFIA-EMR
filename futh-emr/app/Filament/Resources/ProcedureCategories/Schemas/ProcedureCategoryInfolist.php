<?php

namespace App\Filament\Resources\ProcedureCategories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProcedureCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ProcedureCategory Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Category'),
                        TextEntry::make('specialty')->label('Specialty'),
                        TextEntry::make('requires_consent')->label('Consent'),
                        TextEntry::make('requires_anaesthesia')->label('Anaesthesia'),
                        TextEntry::make('is_active')->label('Active'),
                    ])
                    ->columns(2),
            ]);
    }
}
