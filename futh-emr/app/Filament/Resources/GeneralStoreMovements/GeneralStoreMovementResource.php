<?php

namespace App\Filament\Resources\GeneralStoreMovements;

use App\Filament\Resources\GeneralStoreMovements\Pages\CreateGeneralStoreMovement;
use App\Filament\Resources\GeneralStoreMovements\Pages\EditGeneralStoreMovement;
use App\Filament\Resources\GeneralStoreMovements\Pages\ListGeneralStoreMovements;
use App\Filament\Resources\GeneralStoreMovements\Pages\ViewGeneralStoreMovement;
use App\Filament\Resources\GeneralStoreMovements\Schemas\GeneralStoreMovementForm;
use App\Filament\Resources\GeneralStoreMovements\Schemas\GeneralStoreMovementInfolist;
use App\Filament\Resources\GeneralStoreMovements\Tables\GeneralStoreMovementsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\GeneralStoreMovement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GeneralStoreMovementResource extends Resource
{
    use HasUnitScoping;
    protected static ?string $model = GeneralStoreMovement::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;
    protected static string|\UnitEnum|null $navigationGroup = 'General Store';
    protected static ?int $navigationSort = 5;
    protected static ?string $recordTitleAttribute = 'movement_number';
    public static function form(Schema $schema): Schema { return GeneralStoreMovementForm::configure($schema); }
    public static function infolist(Schema $schema): Schema { return GeneralStoreMovementInfolist::configure($schema); }
    public static function table(Table $table): Table { return GeneralStoreMovementsTable::configure($table); }
    public static function getPages(): array { return ['index' => ListGeneralStoreMovements::route('/'), 'create' => CreateGeneralStoreMovement::route('/create'), 'view' => ViewGeneralStoreMovement::route('/{record}'), 'edit' => EditGeneralStoreMovement::route('/{record}/edit')]; }
    public static function getNavigationBadge(): ?string { return number_format(static::getEloquentQuery()->count()); }
    public static function getNavigationBadgeColor(): ?string { return 'success'; }
}
