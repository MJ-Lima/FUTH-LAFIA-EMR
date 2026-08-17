<?php

namespace App\Filament\Resources\ProcedureBookings;

use App\Filament\Resources\ProcedureBookings\Pages\CreateProcedureBooking;
use App\Filament\Resources\ProcedureBookings\Pages\EditProcedureBooking;
use App\Filament\Resources\ProcedureBookings\Pages\ListProcedureBookings;
use App\Filament\Resources\ProcedureBookings\Pages\ViewProcedureBooking;
use App\Filament\Resources\ProcedureBookings\Schemas\ProcedureBookingForm;
use App\Filament\Resources\ProcedureBookings\Schemas\ProcedureBookingInfolist;
use App\Filament\Resources\ProcedureBookings\Tables\ProcedureBookingsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\ProcedureBooking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProcedureBookingResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = ProcedureBooking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Procedures';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'booking_number';

    public static function form(Schema $schema): Schema
    {
        return ProcedureBookingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProcedureBookingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProcedureBookingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListProcedureBookings::route('/'),
            'create' => CreateProcedureBooking::route('/create'),
            'view'   => ViewProcedureBooking::route('/{record}'),
            'edit'   => EditProcedureBooking::route('/{record}/edit'),
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
