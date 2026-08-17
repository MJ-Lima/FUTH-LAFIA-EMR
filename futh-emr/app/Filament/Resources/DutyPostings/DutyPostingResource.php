<?php

namespace App\Filament\Resources\DutyPostings;

use App\Filament\Resources\DutyPostings\Pages\CreateDutyPosting;
use App\Filament\Resources\DutyPostings\Pages\EditDutyPosting;
use App\Filament\Resources\DutyPostings\Pages\ListDutyPostings;
use App\Filament\Resources\DutyPostings\Pages\ViewDutyPosting;
use App\Filament\Resources\DutyPostings\Schemas\DutyPostingForm;
use App\Filament\Resources\DutyPostings\Schemas\DutyPostingInfolist;
use App\Filament\Resources\DutyPostings\Tables\DutyPostingsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\DutyPosting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DutyPostingResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = DutyPosting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Duty & Staff Posting';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DutyPostingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DutyPostingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DutyPostingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDutyPostings::route('/'),
            'create' => CreateDutyPosting::route('/create'),
            'view'   => ViewDutyPosting::route('/{record}'),
            'edit'   => EditDutyPosting::route('/{record}/edit'),
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
