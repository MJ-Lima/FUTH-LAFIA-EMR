<?php

namespace App\Filament\Resources\DrugCategories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DrugCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('DrugCategory Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Category'),
                        TextEntry::make('description')->label('Description'),
                        TextEntry::make('status')->label('Active'),
                    ])
                    ->columns(2),
            ]);
    }
}
