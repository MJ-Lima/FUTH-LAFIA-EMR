<?php

namespace App\Filament\Resources\InternalAudits;

use App\Filament\Resources\InternalAudits\Pages\CreateInternalAudit;
use App\Filament\Resources\InternalAudits\Pages\EditInternalAudit;
use App\Filament\Resources\InternalAudits\Pages\ListInternalAudits;
use App\Filament\Resources\InternalAudits\Pages\ViewInternalAudit;
use App\Filament\Resources\InternalAudits\Schemas\InternalAuditForm;
use App\Filament\Resources\InternalAudits\Schemas\InternalAuditInfolist;
use App\Filament\Resources\InternalAudits\Tables\InternalAuditsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\InternalAudit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InternalAuditResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = InternalAudit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Audit';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'audit_number';

    public static function form(Schema $schema): Schema
    {
        return InternalAuditForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InternalAuditInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternalAuditsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListInternalAudits::route('/'),
            'create' => CreateInternalAudit::route('/create'),
            'view'   => ViewInternalAudit::route('/{record}'),
            'edit'   => EditInternalAudit::route('/{record}/edit'),
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
