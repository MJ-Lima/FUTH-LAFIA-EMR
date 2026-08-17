<?php

namespace App\Filament\Resources\Prescriptions;

use App\Filament\Resources\Prescriptions\Pages\CreatePrescription;
use App\Filament\Resources\Prescriptions\Pages\EditPrescription;
use App\Filament\Resources\Prescriptions\Pages\ListPrescriptions;
use App\Filament\Resources\Prescriptions\Pages\ViewPrescription;
use App\Filament\Resources\Prescriptions\Schemas\PrescriptionForm;
use App\Filament\Resources\Prescriptions\Schemas\PrescriptionInfolist;
use App\Filament\Resources\Prescriptions\Tables\PrescriptionsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\Prescription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PrescriptionResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = Prescription::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Pharmacy';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'prescription_number';

    public static function form(Schema $schema): Schema
    {
        return PrescriptionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PrescriptionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrescriptionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPrescriptions::route('/'),
            'create' => CreatePrescription::route('/create'),
            'view'   => ViewPrescription::route('/{record}'),
            'edit'   => EditPrescription::route('/{record}/edit'),
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
