<?php

namespace App\Filament\Resources\BloodCrossmatches;

use App\Filament\Resources\BloodCrossmatches\Pages\CreateBloodCrossmatch;
use App\Filament\Resources\BloodCrossmatches\Pages\EditBloodCrossmatch;
use App\Filament\Resources\BloodCrossmatches\Pages\ListBloodCrossmatches;
use App\Filament\Resources\BloodCrossmatches\Pages\ViewBloodCrossmatch;
use App\Filament\Resources\BloodCrossmatches\Schemas\BloodCrossmatchForm;
use App\Filament\Resources\BloodCrossmatches\Schemas\BloodCrossmatchInfolist;
use App\Filament\Resources\BloodCrossmatches\Tables\BloodCrossmatchesTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\BloodCrossmatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BloodCrossmatchResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = BloodCrossmatch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowPathRoundedSquare;

    protected static string|\UnitEnum|null $navigationGroup = 'Blood Bank';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'crossmatch_number';

    public static function form(Schema $schema): Schema
    {
        return BloodCrossmatchForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BloodCrossmatchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BloodCrossmatchesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBloodCrossmatches::route('/'),
            'create' => CreateBloodCrossmatch::route('/create'),
            'view'   => ViewBloodCrossmatch::route('/{record}'),
            'edit'   => EditBloodCrossmatch::route('/{record}/edit'),
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
