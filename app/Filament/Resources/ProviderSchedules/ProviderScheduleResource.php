<?php

namespace App\Filament\Resources\ProviderSchedules;

use App\Filament\Resources\ProviderSchedules\Pages\CreateProviderSchedule;
use App\Filament\Resources\ProviderSchedules\Pages\EditProviderSchedule;
use App\Filament\Resources\ProviderSchedules\Pages\ListProviderSchedules;
use App\Filament\Resources\ProviderSchedules\Pages\ViewProviderSchedule;
use App\Filament\Resources\ProviderSchedules\Schemas\ProviderScheduleForm;
use App\Filament\Resources\ProviderSchedules\Schemas\ProviderScheduleInfolist;
use App\Filament\Resources\ProviderSchedules\Tables\ProviderSchedulesTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\ProviderSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProviderScheduleResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = ProviderSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|\UnitEnum|null $navigationGroup = 'Schedule Configuration';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ProviderScheduleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProviderScheduleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProviderSchedulesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListProviderSchedules::route('/'),
            'create' => CreateProviderSchedule::route('/create'),
            'view'   => ViewProviderSchedule::route('/{record}'),
            'edit'   => EditProviderSchedule::route('/{record}/edit'),
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
