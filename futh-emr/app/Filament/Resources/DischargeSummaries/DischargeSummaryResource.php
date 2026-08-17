<?php

namespace App\Filament\Resources\DischargeSummaries;

use App\Filament\Resources\DischargeSummaries\Pages\CreateDischargeSummary;
use App\Filament\Resources\DischargeSummaries\Pages\EditDischargeSummary;
use App\Filament\Resources\DischargeSummaries\Pages\ListDischargeSummaries;
use App\Filament\Resources\DischargeSummaries\Pages\ViewDischargeSummary;
use App\Filament\Resources\DischargeSummaries\Schemas\DischargeSummaryForm;
use App\Filament\Resources\DischargeSummaries\Schemas\DischargeSummaryInfolist;
use App\Filament\Resources\DischargeSummaries\Tables\DischargeSummariesTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\DischargeSummary;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DischargeSummaryResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = DischargeSummary::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Ward & Bed Management';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DischargeSummaryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DischargeSummaryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DischargeSummariesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDischargeSummaries::route('/'),
            'create' => CreateDischargeSummary::route('/create'),
            'view'   => ViewDischargeSummary::route('/{record}'),
            'edit'   => EditDischargeSummary::route('/{record}/edit'),
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
