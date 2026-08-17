<?php

namespace App\Filament\Resources\DutyRosters;

use App\Filament\Resources\DutyRosters\Pages\CreateDutyRoster;
use App\Filament\Resources\DutyRosters\Pages\EditDutyRoster;
use App\Filament\Resources\DutyRosters\Pages\ListDutyRosters;
use App\Filament\Resources\DutyRosters\Pages\ViewDutyRoster;
use App\Filament\Resources\DutyRosters\Schemas\DutyRosterForm;
use App\Filament\Resources\DutyRosters\Schemas\DutyRosterInfolist;
use App\Filament\Resources\DutyRosters\Tables\DutyRostersTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\DutyRoster;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DutyRosterResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = DutyRoster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Duty & Staff Posting';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return DutyRosterForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DutyRosterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DutyRostersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDutyRosters::route('/'),
            'create' => CreateDutyRoster::route('/create'),
            'view'   => ViewDutyRoster::route('/{record}'),
            'edit'   => EditDutyRoster::route('/{record}/edit'),
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
