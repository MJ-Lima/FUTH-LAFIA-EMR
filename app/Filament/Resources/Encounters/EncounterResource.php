<?php

namespace App\Filament\Resources\Encounters;

use Filament\Schemas\Schema;

use App\Filament\Resources\Encounters\Pages\CreateEncounter;
use App\Filament\Resources\Encounters\Pages\EditEncounter;
use App\Filament\Resources\Encounters\Pages\ListEncounters;
use App\Filament\Resources\Encounters\Pages\ViewEncounter;
use App\Filament\Resources\Encounters\RelationManagers\AllergiesRelationManager;
use App\Filament\Resources\Encounters\RelationManagers\ClinicalNotesRelationManager;
use App\Filament\Resources\Encounters\RelationManagers\DiagnosesRelationManager;
use App\Filament\Resources\Encounters\RelationManagers\LabOrdersRelationManager;
use App\Filament\Resources\Encounters\RelationManagers\PrescriptionsRelationManager;
use App\Filament\Resources\Encounters\RelationManagers\RadiologyOrdersRelationManager;
use App\Filament\Resources\Encounters\RelationManagers\VitalsRelationManager;
use App\Filament\Resources\Encounters\Schemas\EncounterForm;
use App\Filament\Resources\Encounters\Schemas\EncounterInfolist;
use App\Filament\Resources\Encounters\Tables\EncountersTable;
use App\Models\Encounter;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EncounterResource extends Resource
{
    protected static ?string $model = Encounter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static \UnitEnum|string|null $navigationGroup = 'Patient Management';

    protected static ?string $recordTitleAttribute = 'encounter_number';

    public static function form(Schema $schema): Schema
    {
        return EncounterForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EncounterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EncountersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ClinicalNotesRelationManager::class,
            VitalsRelationManager::class,
            AllergiesRelationManager::class,
            DiagnosesRelationManager::class,
            LabOrdersRelationManager::class,
            RadiologyOrdersRelationManager::class,
            PrescriptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEncounters::route('/'),
            'create' => CreateEncounter::route('/create'),
            'view' => ViewEncounter::route('/{record}'),
            'edit' => EditEncounter::route('/{record}/edit'),
        ];
    }
}
