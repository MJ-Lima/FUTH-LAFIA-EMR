<?php

namespace App\Filament\Resources\Allergies;

use Filament\Schemas\Schema;

use App\Filament\Resources\Allergies\Pages\CreateAllergy;
use App\Filament\Resources\Allergies\Pages\EditAllergy;
use App\Filament\Resources\Allergies\Pages\ListAllergies;
use App\Filament\Resources\Allergies\Pages\ViewAllergy;
use App\Filament\Resources\Allergies\Schemas\AllergyForm;
use App\Filament\Resources\Allergies\Schemas\AllergyInfolist;
use App\Filament\Resources\Allergies\Tables\AllergiesTable;
use App\Models\Allergy;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AllergyResource extends Resource
{
    protected static ?string $model = Allergy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static \UnitEnum|string|null $navigationGroup = 'Clinical';

    protected static ?string $recordTitleAttribute = 'substance';

    public static function form(Schema $schema): Schema
    {
        return AllergyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AllergyInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AllergiesTable::configure($table);
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
            'index' => ListAllergies::route('/'),
            'create' => CreateAllergy::route('/create'),
            'view' => ViewAllergy::route('/{record}'),
            'edit' => EditAllergy::route('/{record}/edit'),
        ];
    }
}
