<?php

namespace App\Filament\Resources\ProcedureSessions;

use App\Filament\Resources\ProcedureSessions\Pages\CreateProcedureSession;
use App\Filament\Resources\ProcedureSessions\Pages\EditProcedureSession;
use App\Filament\Resources\ProcedureSessions\Pages\ListProcedureSessions;
use App\Filament\Resources\ProcedureSessions\Pages\ViewProcedureSession;
use App\Filament\Resources\ProcedureSessions\Schemas\ProcedureSessionForm;
use App\Filament\Resources\ProcedureSessions\Schemas\ProcedureSessionInfolist;
use App\Filament\Resources\ProcedureSessions\Tables\ProcedureSessionsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\ProcedureSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProcedureSessionResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = ProcedureSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Procedures';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'session_number';

    public static function form(Schema $schema): Schema
    {
        return ProcedureSessionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProcedureSessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProcedureSessionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListProcedureSessions::route('/'),
            'create' => CreateProcedureSession::route('/create'),
            'view'   => ViewProcedureSession::route('/{record}'),
            'edit'   => EditProcedureSession::route('/{record}/edit'),
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
