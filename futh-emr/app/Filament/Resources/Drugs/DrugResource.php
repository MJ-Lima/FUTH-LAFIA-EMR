<?php

namespace App\Filament\Resources\Drugs;

use App\Filament\Resources\Drugs\Pages\CreateDrug;
use App\Filament\Resources\Drugs\Pages\EditDrug;
use App\Filament\Resources\Drugs\Pages\ListDrugs;
use App\Filament\Resources\Drugs\Pages\ViewDrug;
use App\Filament\Resources\Drugs\Schemas\DrugForm;
use App\Filament\Resources\Drugs\Schemas\DrugInfolist;
use App\Filament\Resources\Drugs\Tables\DrugsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\Drug;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DrugResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = Drug::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static string|\UnitEnum|null $navigationGroup = 'Pharmacy';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return DrugForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DrugInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DrugsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDrugs::route('/'),
            'create' => CreateDrug::route('/create'),
            'view'   => ViewDrug::route('/{record}'),
            'edit'   => EditDrug::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getEloquentQuery()->count());
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
