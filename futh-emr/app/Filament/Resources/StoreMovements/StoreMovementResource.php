<?php

namespace App\Filament\Resources\StoreMovements;

use App\Filament\Resources\StoreMovements\Pages\CreateStoreMovement;
use App\Filament\Resources\StoreMovements\Pages\EditStoreMovement;
use App\Filament\Resources\StoreMovements\Pages\ListStoreMovements;
use App\Filament\Resources\StoreMovements\Pages\ViewStoreMovement;
use App\Filament\Resources\StoreMovements\Schemas\StoreMovementForm;
use App\Filament\Resources\StoreMovements\Schemas\StoreMovementInfolist;
use App\Filament\Resources\StoreMovements\Tables\StoreMovementsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\StoreMovement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StoreMovementResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = StoreMovement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static string|\UnitEnum|null $navigationGroup = 'Store & Inventory';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'movement_number';

    public static function form(Schema $schema): Schema
    {
        return StoreMovementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StoreMovementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StoreMovementsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListStoreMovements::route('/'),
            'create' => CreateStoreMovement::route('/create'),
            'view'   => ViewStoreMovement::route('/{record}'),
            'edit'   => EditStoreMovement::route('/{record}/edit'),
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
