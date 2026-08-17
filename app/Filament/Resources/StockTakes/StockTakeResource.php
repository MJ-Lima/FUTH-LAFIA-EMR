<?php

namespace App\Filament\Resources\StockTakes;

use App\Filament\Resources\StockTakes\Pages\CreateStockTake;
use App\Filament\Resources\StockTakes\Pages\EditStockTake;
use App\Filament\Resources\StockTakes\Pages\ListStockTakes;
use App\Filament\Resources\StockTakes\Pages\ViewStockTake;
use App\Filament\Resources\StockTakes\Schemas\StockTakeForm;
use App\Filament\Resources\StockTakes\Schemas\StockTakeInfolist;
use App\Filament\Resources\StockTakes\Tables\StockTakesTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\StockTake;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StockTakeResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = StockTake::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Store & Inventory';

    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'stock_take_number';

    public static function form(Schema $schema): Schema
    {
        return StockTakeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StockTakeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockTakesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListStockTakes::route('/'),
            'create' => CreateStockTake::route('/create'),
            'view'   => ViewStockTake::route('/{record}'),
            'edit'   => EditStockTake::route('/{record}/edit'),
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
