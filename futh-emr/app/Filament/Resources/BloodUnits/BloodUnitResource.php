<?php

namespace App\Filament\Resources\BloodUnits;

use App\Filament\Resources\BloodUnits\Pages\CreateBloodUnit;
use App\Filament\Resources\BloodUnits\Pages\EditBloodUnit;
use App\Filament\Resources\BloodUnits\Pages\ListBloodUnits;
use App\Filament\Resources\BloodUnits\Pages\ViewBloodUnit;
use App\Filament\Resources\BloodUnits\Schemas\BloodUnitForm;
use App\Filament\Resources\BloodUnits\Schemas\BloodUnitInfolist;
use App\Filament\Resources\BloodUnits\Tables\BloodUnitsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\BloodUnit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BloodUnitResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = BloodUnit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static string|\UnitEnum|null $navigationGroup = 'Blood Bank';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'unit_number';

    public static function form(Schema $schema): Schema
    {
        return BloodUnitForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BloodUnitInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BloodUnitsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBloodUnits::route('/'),
            'create' => CreateBloodUnit::route('/create'),
            'view'   => ViewBloodUnit::route('/{record}'),
            'edit'   => EditBloodUnit::route('/{record}/edit'),
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
