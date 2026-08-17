<?php

namespace App\Filament\Resources\Vitals;

use App\Filament\Resources\Vitals\Pages\CreateVitals;
use App\Filament\Resources\Vitals\Pages\EditVitals;
use App\Filament\Resources\Vitals\Pages\ListVitals;
use App\Filament\Resources\Vitals\Pages\ViewVitals;
use App\Filament\Resources\Vitals\Schemas\VitalsForm;
use App\Filament\Resources\Vitals\Schemas\VitalsInfolist;
use App\Filament\Resources\Vitals\Tables\VitalsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\Vitals;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VitalsResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = Vitals::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static string|\UnitEnum|null $navigationGroup = 'Clinical';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return VitalsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VitalsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VitalsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListVitals::route('/'),
            'create' => CreateVitals::route('/create'),
            'view'   => ViewVitals::route('/{record}'),
            'edit'   => EditVitals::route('/{record}/edit'),
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
