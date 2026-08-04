<?php

namespace App\Filament\Resources\DrugCategories;

use Filament\Schemas\Schema;

use App\Filament\Resources\DrugCategories\Pages\CreateDrugCategory;
use App\Filament\Resources\DrugCategories\Pages\EditDrugCategory;
use App\Filament\Resources\DrugCategories\Pages\ListDrugCategories;
use App\Filament\Resources\DrugCategories\Pages\ViewDrugCategory;
use App\Filament\Resources\DrugCategories\Schemas\DrugCategoryForm;
use App\Filament\Resources\DrugCategories\Schemas\DrugCategoryInfolist;
use App\Filament\Resources\DrugCategories\Tables\DrugCategoriesTable;
use App\Models\DrugCategory;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DrugCategoryResource extends Resource
{
    protected static ?string $model = DrugCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static \UnitEnum|string|null $navigationGroup = 'Pharmacy';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DrugCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DrugCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DrugCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDrugCategories::route('/'),
            'create' => CreateDrugCategory::route('/create'),
            'view' => ViewDrugCategory::route('/{record}'),
            'edit' => EditDrugCategory::route('/{record}/edit'),
        ];
    }
}
