<?php

namespace App\Filament\Resources\DrugCategories\Schemas;

use Filament\Forms\Components\TextInput, Textarea, Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class DrugCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('DrugCategory Details')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')->label('Category Name')->required(),
                            TextInput::make('code')->label('Code')->required(),
                            Textarea::make('description')->label('Description'),
                            Toggle::make('status')->label('Active'),
                        ]),
                    ]),
            ]);
    }
}
