<?php

namespace App\Filament\Resources\ClinicSchedules;

use App\Filament\Resources\ClinicSchedules\Pages\CreateClinicSchedule;
use App\Filament\Resources\ClinicSchedules\Pages\EditClinicSchedule;
use App\Filament\Resources\ClinicSchedules\Pages\ListClinicSchedules;
use App\Filament\Resources\ClinicSchedules\Pages\ViewClinicSchedule;
use App\Filament\Resources\ClinicSchedules\Schemas\ClinicScheduleForm;
use App\Filament\Resources\ClinicSchedules\Schemas\ClinicScheduleInfolist;
use App\Filament\Resources\ClinicSchedules\Tables\ClinicSchedulesTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\ClinicSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClinicScheduleResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = ClinicSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Schedule Configuration';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ClinicScheduleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClinicScheduleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClinicSchedulesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListClinicSchedules::route('/'),
            'create' => CreateClinicSchedule::route('/create'),
            'view'   => ViewClinicSchedule::route('/{record}'),
            'edit'   => EditClinicSchedule::route('/{record}/edit'),
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
