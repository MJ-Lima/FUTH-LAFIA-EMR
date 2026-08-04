<?php

namespace App\Filament\Resources\DrugCategories\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class DrugCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Information')
                    ->schema([
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('code')->label('Code')->badge(),
                        TextEntry::make('description')->columnSpanFull(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->state(fn ($record) => $record->status ? 'Active' : 'Inactive')
                            ->color(fn ($state) => $state === 'Active' ? 'success' : 'gray'),
                        TextEntry::make('created_at')->dateTime(),
                        TextEntry::make('updated_at')->dateTime(),
                    ])->columns(2),
            ]);
    }
}
