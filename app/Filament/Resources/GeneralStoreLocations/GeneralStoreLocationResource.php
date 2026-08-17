<?php

namespace App\Filament\Resources\GeneralStoreLocations;

use App\Filament\Resources\GeneralStoreLocations\Pages\CreateGeneralStoreLocation;
use App\Filament\Resources\GeneralStoreLocations\Pages\EditGeneralStoreLocation;
use App\Filament\Resources\GeneralStoreLocations\Pages\ListGeneralStoreLocations;
use App\Filament\Resources\GeneralStoreLocations\Pages\ViewGeneralStoreLocation;
use App\Filament\Resources\GeneralStoreLocations\Schemas\GeneralStoreLocationForm;
use App\Filament\Resources\GeneralStoreLocations\Schemas\GeneralStoreLocationInfolist;
use App\Filament\Resources\GeneralStoreLocations\Tables\GeneralStoreLocationsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\GeneralStoreLocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GeneralStoreLocationResource extends Resource
{
    use HasUnitScoping;
    protected static ?string $model = GeneralStoreLocation::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;
    protected static string|\UnitEnum|null $navigationGroup = 'General Store';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'code';
    public static function form(Schema $schema): Schema { return GeneralStoreLocationForm::configure($schema); }
    public static function infolist(Schema $schema): Schema { return GeneralStoreLocationInfolist::configure($schema); }
    public static function table(Table $table): Table { return GeneralStoreLocationsTable::configure($table); }
    public static function getPages(): array { return ['index' => ListGeneralStoreLocations::route('/'), 'create' => CreateGeneralStoreLocation::route('/create'), 'view' => ViewGeneralStoreLocation::route('/{record}'), 'edit' => EditGeneralStoreLocation::route('/{record}/edit')]; }
    public static function getNavigationBadge(): ?string { return number_format(static::getEloquentQuery()->count()); }
    public static function getNavigationBadgeColor(): ?string { return 'success'; }
}
