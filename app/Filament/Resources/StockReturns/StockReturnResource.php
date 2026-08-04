<?php

namespace App\Filament\Resources\StockReturns;

use Filament\Schemas\Schema;

use App\Filament\Resources\StockReturns\Pages\CreateStockReturn;
use App\Filament\Resources\StockReturns\Pages\EditStockReturn;
use App\Filament\Resources\StockReturns\Pages\ListStockReturns;
use App\Filament\Resources\StockReturns\Pages\ViewStockReturn;
use App\Filament\Resources\StockReturns\Schemas\StockReturnForm;
use App\Filament\Resources\StockReturns\Schemas\StockReturnInfolist;
use App\Filament\Resources\StockReturns\Tables\StockReturnsTable;
use App\Models\StockReturn;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StockReturnResource extends Resource
{
    protected static ?string $model = StockReturn::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUturnLeft;

    protected static \UnitEnum|string|null $navigationGroup = 'Pharmacy';

    protected static ?string $recordTitleAttribute = 'stockreturn_number';

    public static function form(Schema $schema): Schema
    {
        return StockReturnForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StockReturnInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockReturnsTable::configure($table);
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
            'index' => ListStockReturns::route('/'),
            'create' => CreateStockReturn::route('/create'),
            'view' => ViewStockReturn::route('/{record}'),
            'edit' => EditStockReturn::route('/{record}/edit'),
        ];
    }
}
