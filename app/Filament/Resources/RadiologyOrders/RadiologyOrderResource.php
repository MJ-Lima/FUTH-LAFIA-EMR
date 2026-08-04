<?php

namespace App\Filament\Resources\RadiologyOrders;

use Filament\Schemas\Schema;

use App\Filament\Resources\RadiologyOrders\Pages\CreateRadiologyOrder;
use App\Filament\Resources\RadiologyOrders\Pages\EditRadiologyOrder;
use App\Filament\Resources\RadiologyOrders\Pages\ListRadiologyOrders;
use App\Filament\Resources\RadiologyOrders\Pages\ViewRadiologyOrder;
use App\Filament\Resources\RadiologyOrders\RelationManagers\ResultRelationManager;
use App\Filament\Resources\RadiologyOrders\Schemas\RadiologyOrderForm;
use App\Filament\Resources\RadiologyOrders\Schemas\RadiologyOrderInfolist;
use App\Filament\Resources\RadiologyOrders\Tables\RadiologyOrdersTable;
use App\Models\RadiologyOrder;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RadiologyOrderResource extends Resource
{
    protected static ?string $model = RadiologyOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static \UnitEnum|string|null $navigationGroup = 'Radiology';

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

    public static function getRelations(): array
    {
        return [
            ResultRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRadiologyOrders::route('/'),
            'create' => CreateRadiologyOrder::route('/create'),
            'view' => ViewRadiologyOrder::route('/{record}'),
            'edit' => EditRadiologyOrder::route('/{record}/edit'),
        ];
    }
}
