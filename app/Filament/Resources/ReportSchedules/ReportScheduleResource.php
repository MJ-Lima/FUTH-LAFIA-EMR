<?php

namespace App\Filament\Resources\ReportSchedules;

use App\Filament\Resources\ReportSchedules\Pages\CreateReportSchedule;
use App\Filament\Resources\ReportSchedules\Pages\EditReportSchedule;
use App\Filament\Resources\ReportSchedules\Pages\ListReportSchedules;
use App\Filament\Resources\ReportSchedules\Pages\ViewReportSchedule;
use App\Filament\Resources\ReportSchedules\Schemas\ReportScheduleForm;
use App\Filament\Resources\ReportSchedules\Schemas\ReportScheduleInfolist;
use App\Filament\Resources\ReportSchedules\Tables\ReportSchedulesTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\ReportSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReportScheduleResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = ReportSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ReportScheduleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReportScheduleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReportSchedulesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListReportSchedules::route('/'),
            'create' => CreateReportSchedule::route('/create'),
            'view'   => ViewReportSchedule::route('/{record}'),
            'edit'   => EditReportSchedule::route('/{record}/edit'),
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
