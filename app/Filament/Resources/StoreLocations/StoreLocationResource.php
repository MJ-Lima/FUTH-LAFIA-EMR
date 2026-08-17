<?php

namespace App\Filament\Resources\StoreLocations;

use App\Filament\Resources\StoreLocations\Pages\CreateStoreLocation;
use App\Filament\Resources\StoreLocations\Pages\EditStoreLocation;
use App\Filament\Resources\StoreLocations\Pages\ListStoreLocations;
use App\Filament\Resources\StoreLocations\Pages\ViewStoreLocation;
use App\Filament\Resources\StoreLocations\Schemas\StoreLocationForm;
use App\Filament\Resources\StoreLocations\Schemas\StoreLocationInfolist;
use App\Filament\Resources\StoreLocations\Tables\StoreLocationsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\StoreLocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StoreLocationResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = StoreLocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static string|\UnitEnum|null $navigationGroup = 'Store & Inventory';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return StoreLocationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StoreLocationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StoreLocationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListStoreLocations::route('/'),
            'create' => CreateStoreLocation::route('/create'),
            'view'   => ViewStoreLocation::route('/{record}'),
            'edit'   => EditStoreLocation::route('/{record}/edit'),
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
