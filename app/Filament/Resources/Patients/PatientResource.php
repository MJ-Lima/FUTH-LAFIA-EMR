<?php

namespace App\Filament\Resources\Patients;

use Filament\Schemas\Schema;

use App\Filament\Resources\Patients\Pages\CreatePatient;
use App\Filament\Resources\Patients\Pages\EditPatient;
use App\Filament\Resources\Patients\Pages\ListPatients;
use App\Filament\Resources\Patients\Pages\ViewPatient;
use App\Filament\Resources\Patients\RelationManagers\AllergiesRelationManager;
use App\Filament\Resources\Patients\RelationManagers\AppointmentsRelationManager;
use App\Filament\Resources\Patients\RelationManagers\ClinicalNotesRelationManager;
use App\Filament\Resources\Patients\RelationManagers\DiagnosesRelationManager;
use App\Filament\Resources\Patients\RelationManagers\EncountersRelationManager;
use App\Filament\Resources\Patients\RelationManagers\LabOrdersRelationManager;
use App\Filament\Resources\Patients\RelationManagers\PrescriptionsRelationManager;
use App\Filament\Resources\Patients\RelationManagers\RadiologyOrdersRelationManager;
use App\Filament\Resources\Patients\RelationManagers\VitalsRelationManager;
use App\Filament\Resources\Patients\Schemas\PatientForm;
use App\Filament\Resources\Patients\Schemas\PatientInfolist;
use App\Filament\Resources\Patients\Tables\PatientsTable;
use App\Models\Patient;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static \UnitEnum|string|null $navigationGroup = 'Patient Management';

    public static function form(Schema $schema): Schema
    {
        return PatientForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PatientInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PatientsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            EncountersRelationManager::class,
            AppointmentsRelationManager::class,
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
            'index' => ListPatients::route('/'),
            'create' => CreatePatient::route('/create'),
            'view' => ViewPatient::route('/{record}'),
            'edit' => EditPatient::route('/{record}/edit'),
        ];
    }
}
