<?php

namespace App\Filament\Resources\BloodTransfusions;

use App\Filament\Resources\BloodTransfusions\Pages\CreateBloodTransfusion;
use App\Filament\Resources\BloodTransfusions\Pages\EditBloodTransfusion;
use App\Filament\Resources\BloodTransfusions\Pages\ListBloodTransfusions;
use App\Filament\Resources\BloodTransfusions\Pages\ViewBloodTransfusion;
use App\Filament\Resources\BloodTransfusions\Schemas\BloodTransfusionForm;
use App\Filament\Resources\BloodTransfusions\Schemas\BloodTransfusionInfolist;
use App\Filament\Resources\BloodTransfusions\Tables\BloodTransfusionsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\BloodTransfusion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BloodTransfusionResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = BloodTransfusion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static string|\UnitEnum|null $navigationGroup = 'Blood Bank';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'transfusion_number';

    public static function form(Schema $schema): Schema
    {
        return BloodTransfusionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BloodTransfusionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BloodTransfusionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBloodTransfusions::route('/'),
            'create' => CreateBloodTransfusion::route('/create'),
            'view'   => ViewBloodTransfusion::route('/{record}'),
            'edit'   => EditBloodTransfusion::route('/{record}/edit'),
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
