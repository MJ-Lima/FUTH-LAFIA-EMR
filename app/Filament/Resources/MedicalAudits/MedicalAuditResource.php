<?php

namespace App\Filament\Resources\MedicalAudits;

use App\Filament\Resources\MedicalAudits\Pages\CreateMedicalAudit;
use App\Filament\Resources\MedicalAudits\Pages\EditMedicalAudit;
use App\Filament\Resources\MedicalAudits\Pages\ListMedicalAudits;
use App\Filament\Resources\MedicalAudits\Pages\ViewMedicalAudit;
use App\Filament\Resources\MedicalAudits\Schemas\MedicalAuditForm;
use App\Filament\Resources\MedicalAudits\Schemas\MedicalAuditInfolist;
use App\Filament\Resources\MedicalAudits\Tables\MedicalAuditsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\MedicalAudit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MedicalAuditResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = MedicalAudit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Audit';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'audit_number';

    public static function form(Schema $schema): Schema
    {
        return MedicalAuditForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MedicalAuditInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MedicalAuditsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListMedicalAudits::route('/'),
            'create' => CreateMedicalAudit::route('/create'),
            'view'   => ViewMedicalAudit::route('/{record}'),
            'edit'   => EditMedicalAudit::route('/{record}/edit'),
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
