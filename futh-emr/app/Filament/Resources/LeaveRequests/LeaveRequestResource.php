<?php

namespace App\Filament\Resources\LeaveRequests;

use App\Filament\Resources\LeaveRequests\Pages\CreateLeaveRequest;
use App\Filament\Resources\LeaveRequests\Pages\EditLeaveRequest;
use App\Filament\Resources\LeaveRequests\Pages\ListLeaveRequests;
use App\Filament\Resources\LeaveRequests\Pages\ViewLeaveRequest;
use App\Filament\Resources\LeaveRequests\Schemas\LeaveRequestForm;
use App\Filament\Resources\LeaveRequests\Schemas\LeaveRequestInfolist;
use App\Filament\Resources\LeaveRequests\Tables\LeaveRequestsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\LeaveRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LeaveRequestResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = LeaveRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Schedule Configuration';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'leave_number';

    public static function form(Schema $schema): Schema
    {
        return LeaveRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LeaveRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeaveRequestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListLeaveRequests::route('/'),
            'create' => CreateLeaveRequest::route('/create'),
            'view'   => ViewLeaveRequest::route('/{record}'),
            'edit'   => EditLeaveRequest::route('/{record}/edit'),
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
