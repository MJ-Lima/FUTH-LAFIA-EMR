<?php

namespace App\Filament\Resources\InternalAuditFindings;

use App\Filament\Resources\InternalAuditFindings\Pages\CreateInternalAuditFinding;
use App\Filament\Resources\InternalAuditFindings\Pages\EditInternalAuditFinding;
use App\Filament\Resources\InternalAuditFindings\Pages\ListInternalAuditFindings;
use App\Filament\Resources\InternalAuditFindings\Pages\ViewInternalAuditFinding;
use App\Filament\Resources\InternalAuditFindings\Schemas\InternalAuditFindingForm;
use App\Filament\Resources\InternalAuditFindings\Schemas\InternalAuditFindingInfolist;
use App\Filament\Resources\InternalAuditFindings\Tables\InternalAuditFindingsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\InternalAuditFinding;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InternalAuditFindingResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = InternalAuditFinding::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Audit';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'finding_number';

    public static function form(Schema $schema): Schema
    {
        return InternalAuditFindingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InternalAuditFindingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternalAuditFindingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListInternalAuditFindings::route('/'),
            'create' => CreateInternalAuditFinding::route('/create'),
            'view'   => ViewInternalAuditFinding::route('/{record}'),
            'edit'   => EditInternalAuditFinding::route('/{record}/edit'),
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
