<?php

namespace App\Filament\Resources\Vitals;

use Filament\Schemas\Schema;


use App\Filament\Resources\Vitals\Pages\CreateVitals;
use App\Filament\Resources\Vitals\Pages\EditVitals;
use App\Filament\Resources\Vitals\Pages\ListVitals;
use App\Filament\Resources\Vitals\Pages\ViewVitals;
use App\Filament\Resources\Vitals\Schemas\VitalsForm;
use App\Filament\Resources\Vitals\Schemas\VitalsInfolist;
use App\Filament\Resources\Vitals\Tables\VitalsTable;
use App\Models\Vitals;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VitalsResource extends Resource
{
    protected static ?string $model = Vitals::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static \UnitEnum|string|null $navigationGroup = 'Clinical';

    protected static ?string $recordTitleAttribute = 'recorded_at';

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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVitals::route('/'),
            'create' => CreateVitals::route('/create'),
            'view' => ViewVitals::route('/{record}'),
            'edit' => EditVitals::route('/{record}/edit'),
        ];
    }
}
