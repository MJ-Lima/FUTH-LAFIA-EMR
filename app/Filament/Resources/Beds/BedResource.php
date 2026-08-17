<?php

namespace App\Filament\Resources\Beds;

use App\Filament\Resources\Beds\Pages\CreateBed;
use App\Filament\Resources\Beds\Pages\EditBed;
use App\Filament\Resources\Beds\Pages\ListBeds;
use App\Filament\Resources\Beds\Pages\ViewBed;
use App\Filament\Resources\Beds\Schemas\BedForm;
use App\Filament\Resources\Beds\Schemas\BedInfolist;
use App\Filament\Resources\Beds\Tables\BedsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\Bed;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BedResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = Bed::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Ward & Bed Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'bed_number';

    public static function form(Schema $schema): Schema
    {
        return BedForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BedInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BedsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBeds::route('/'),
            'create' => CreateBed::route('/create'),
            'view'   => ViewBed::route('/{record}'),
            'edit'   => EditBed::route('/{record}/edit'),
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
