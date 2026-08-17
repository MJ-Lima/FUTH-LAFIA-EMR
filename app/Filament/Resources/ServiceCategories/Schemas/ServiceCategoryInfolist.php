<?php

namespace App\Filament\Resources\ServiceCategories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ServiceCategory Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Category'),
                        TextEntry::make('type')->label('Type'),
                        TextEntry::make('color')->label('Color'),
                        TextEntry::make('is_active')->label('Active'),
                    ])
                    ->columns(2),
            ]);
    }
}
