<?php

namespace App\Filament\Resources\GeneralStoreStocks;

use App\Filament\Resources\GeneralStoreStocks\Pages\CreateGeneralStoreStock;
use App\Filament\Resources\GeneralStoreStocks\Pages\EditGeneralStoreStock;
use App\Filament\Resources\GeneralStoreStocks\Pages\ListGeneralStoreStocks;
use App\Filament\Resources\GeneralStoreStocks\Pages\ViewGeneralStoreStock;
use App\Filament\Resources\GeneralStoreStocks\Schemas\GeneralStoreStockForm;
use App\Filament\Resources\GeneralStoreStocks\Schemas\GeneralStoreStockInfolist;
use App\Filament\Resources\GeneralStoreStocks\Tables\GeneralStoreStocksTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\GeneralStoreStock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GeneralStoreStockResource extends Resource
{
    use HasUnitScoping;
    protected static ?string $model = GeneralStoreStock::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|\UnitEnum|null $navigationGroup = 'General Store';
    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Schema $schema): Schema { return GeneralStoreStockForm::configure($schema); }
    public static function infolist(Schema $schema): Schema { return GeneralStoreStockInfolist::configure($schema); }
    public static function table(Table $table): Table { return GeneralStoreStocksTable::configure($table); }
    public static function getPages(): array { return ['index' => ListGeneralStoreStocks::route('/'), 'create' => CreateGeneralStoreStock::route('/create'), 'view' => ViewGeneralStoreStock::route('/{record}'), 'edit' => EditGeneralStoreStock::route('/{record}/edit')]; }
    public static function getNavigationBadge(): ?string { return number_format(static::getEloquentQuery()->count()); }
    public static function getNavigationBadgeColor(): ?string { return 'success'; }
}
