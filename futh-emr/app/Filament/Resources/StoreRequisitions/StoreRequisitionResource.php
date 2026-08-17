<?php

namespace App\Filament\Resources\StoreRequisitions;

use App\Filament\Resources\StoreRequisitions\Pages\CreateStoreRequisition;
use App\Filament\Resources\StoreRequisitions\Pages\EditStoreRequisition;
use App\Filament\Resources\StoreRequisitions\Pages\ListStoreRequisitions;
use App\Filament\Resources\StoreRequisitions\Pages\ViewStoreRequisition;
use App\Filament\Resources\StoreRequisitions\Schemas\StoreRequisitionForm;
use App\Filament\Resources\StoreRequisitions\Schemas\StoreRequisitionInfolist;
use App\Filament\Resources\StoreRequisitions\Tables\StoreRequisitionsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\StoreRequisition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StoreRequisitionResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = StoreRequisition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|\UnitEnum|null $navigationGroup = 'Store & Inventory';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'requisition_number';

    public static function form(Schema $schema): Schema
    {
        return StoreRequisitionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StoreRequisitionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StoreRequisitionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListStoreRequisitions::route('/'),
            'create' => CreateStoreRequisition::route('/create'),
            'view'   => ViewStoreRequisition::route('/{record}'),
            'edit'   => EditStoreRequisition::route('/{record}/edit'),
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
