<?php

namespace App\Filament\Resources\RadiologyOrders;

use App\Filament\Resources\RadiologyOrders\Pages\CreateRadiologyOrder;
use App\Filament\Resources\RadiologyOrders\Pages\EditRadiologyOrder;
use App\Filament\Resources\RadiologyOrders\Pages\ListRadiologyOrders;
use App\Filament\Resources\RadiologyOrders\Pages\ViewRadiologyOrder;
use App\Filament\Resources\RadiologyOrders\Schemas\RadiologyOrderForm;
use App\Filament\Resources\RadiologyOrders\Schemas\RadiologyOrderInfolist;
use App\Filament\Resources\RadiologyOrders\Tables\RadiologyOrdersTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\RadiologyOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RadiologyOrderResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = RadiologyOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Radiology';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'order_number';

    public static function form(Schema $schema): Schema
    {
        return RadiologyOrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RadiologyOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RadiologyOrdersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListRadiologyOrders::route('/'),
            'create' => CreateRadiologyOrder::route('/create'),
            'view'   => ViewRadiologyOrder::route('/{record}'),
            'edit'   => EditRadiologyOrder::route('/{record}/edit'),
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
