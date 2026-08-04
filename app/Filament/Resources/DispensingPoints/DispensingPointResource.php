<?php

namespace App\Filament\Resources\DispensingPoints;

use Filament\Schemas\Schema;

use App\Filament\Resources\DispensingPoints\Pages\CreateDispensingPoint;
use App\Filament\Resources\DispensingPoints\Pages\EditDispensingPoint;
use App\Filament\Resources\DispensingPoints\Pages\ListDispensingPoints;
use App\Filament\Resources\DispensingPoints\Pages\ViewDispensingPoint;
use App\Filament\Resources\DispensingPoints\Schemas\DispensingPointForm;
use App\Filament\Resources\DispensingPoints\Schemas\DispensingPointInfolist;
use App\Filament\Resources\DispensingPoints\Tables\DispensingPointsTable;
use App\Models\DispensingPoint;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DispensingPointResource extends Resource
{
    protected static ?string $model = DispensingPoint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static \UnitEnum|string|null $navigationGroup = 'Pharmacy';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DispensingPointForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DispensingPointInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DispensingPointsTable::configure($table);
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
            'index' => ListDispensingPoints::route('/'),
            'create' => CreateDispensingPoint::route('/create'),
            'view' => ViewDispensingPoint::route('/{record}'),
            'edit' => EditDispensingPoint::route('/{record}/edit'),
        ];
    }
}
