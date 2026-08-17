<?php

namespace App\Filament\Resources\Patients;

use App\Filament\Resources\Patients\Pages\{CreatePatient, EditPatient, ListPatients, ViewPatient};
use App\Filament\Resources\Patients\Schemas\{PatientForm, PatientInfolist};
use App\Filament\Resources\Patients\Tables\PatientsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\Patient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = Patient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|\UnitEnum|null $navigationGroup = 'Patient Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'patientcode';

    // Hide from navigation if user lacks "view patient" permission
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view patient') ?? false;
    }

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

    public static function getPages(): array
    {
        return [
            'index'  => ListPatients::route('/'),
            'create' => CreatePatient::route('/create'),
            'view'   => ViewPatient::route('/{record}'),
            'edit'   => EditPatient::route('/{record}/edit'),
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