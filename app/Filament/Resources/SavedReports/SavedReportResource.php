<?php

namespace App\Filament\Resources\SavedReports;

use App\Filament\Resources\SavedReports\Pages\CreateSavedReport;
use App\Filament\Resources\SavedReports\Pages\EditSavedReport;
use App\Filament\Resources\SavedReports\Pages\ListSavedReports;
use App\Filament\Resources\SavedReports\Pages\ViewSavedReport;
use App\Filament\Resources\SavedReports\Schemas\SavedReportForm;
use App\Filament\Resources\SavedReports\Schemas\SavedReportInfolist;
use App\Filament\Resources\SavedReports\Tables\SavedReportsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\SavedReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SavedReportResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = SavedReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'report_number';

    public static function form(Schema $schema): Schema
    {
        return SavedReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SavedReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SavedReportsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSavedReports::route('/'),
            'create' => CreateSavedReport::route('/create'),
            'view'   => ViewSavedReport::route('/{record}'),
            'edit'   => EditSavedReport::route('/{record}/edit'),
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
