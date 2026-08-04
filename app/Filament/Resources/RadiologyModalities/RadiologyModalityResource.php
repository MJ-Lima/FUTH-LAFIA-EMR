<?php

namespace App\Filament\Resources\RadiologyModalities;

use Filament\Schemas\Schema;

use App\Filament\Resources\RadiologyModalities\Pages\CreateRadiologyModality;
use App\Filament\Resources\RadiologyModalities\Pages\EditRadiologyModality;
use App\Filament\Resources\RadiologyModalities\Pages\ListRadiologyModalities;
use App\Filament\Resources\RadiologyModalities\Pages\ViewRadiologyModality;
use App\Filament\Resources\RadiologyModalities\Schemas\RadiologyModalityForm;
use App\Filament\Resources\RadiologyModalities\Schemas\RadiologyModalityInfolist;
use App\Filament\Resources\RadiologyModalities\Tables\RadiologyModalitiesTable;
use App\Models\RadiologyModality;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RadiologyModalityResource extends Resource
{
    protected static ?string $model = RadiologyModality::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedViewfinderCircle;

    protected static \UnitEnum|string|null $navigationGroup = 'Radiology';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RadiologyModalityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RadiologyModalityInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RadiologyModalitiesTable::configure($table);
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
            'index' => ListRadiologyModalities::route('/'),
            'create' => CreateRadiologyModality::route('/create'),
            'view' => ViewRadiologyModality::route('/{record}'),
            'edit' => EditRadiologyModality::route('/{record}/edit'),
        ];
    }
}
