<?php

namespace App\Filament\Resources\MedicalAuditFindings;

use App\Filament\Resources\MedicalAuditFindings\Pages\CreateMedicalAuditFinding;
use App\Filament\Resources\MedicalAuditFindings\Pages\EditMedicalAuditFinding;
use App\Filament\Resources\MedicalAuditFindings\Pages\ListMedicalAuditFindings;
use App\Filament\Resources\MedicalAuditFindings\Pages\ViewMedicalAuditFinding;
use App\Filament\Resources\MedicalAuditFindings\Schemas\MedicalAuditFindingForm;
use App\Filament\Resources\MedicalAuditFindings\Schemas\MedicalAuditFindingInfolist;
use App\Filament\Resources\MedicalAuditFindings\Tables\MedicalAuditFindingsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\MedicalAuditFinding;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MedicalAuditFindingResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = MedicalAuditFinding::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static string|\UnitEnum|null $navigationGroup = 'Audit';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'finding_number';

    public static function form(Schema $schema): Schema
    {
        return MedicalAuditFindingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MedicalAuditFindingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MedicalAuditFindingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListMedicalAuditFindings::route('/'),
            'create' => CreateMedicalAuditFinding::route('/create'),
            'view'   => ViewMedicalAuditFinding::route('/{record}'),
            'edit'   => EditMedicalAuditFinding::route('/{record}/edit'),
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
