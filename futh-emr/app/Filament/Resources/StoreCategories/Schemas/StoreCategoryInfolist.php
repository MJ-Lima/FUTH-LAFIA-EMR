<?php

namespace App\Filament\Resources\StoreCategories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StoreCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('StoreCategory Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Category'),
                        TextEntry::make('type')->label('Type'),
                        TextEntry::make('description')->label('Description'),
                        TextEntry::make('is_active')->label('Active'),
                    ])
                    ->columns(2),
            ]);
    }
}
