<?php

namespace App\Filament\Resources\DrugBatches;

use App\Filament\Resources\DrugBatches\Pages\CreateDrugBatch;
use App\Filament\Resources\DrugBatches\Pages\EditDrugBatch;
use App\Filament\Resources\DrugBatches\Pages\ListDrugBatches;
use App\Filament\Resources\DrugBatches\Pages\ViewDrugBatch;
use App\Filament\Resources\DrugBatches\Schemas\DrugBatchForm;
use App\Filament\Resources\DrugBatches\Schemas\DrugBatchInfolist;
use App\Filament\Resources\DrugBatches\Tables\DrugBatchesTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\DrugBatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DrugBatchResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = DrugBatch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCubeTransparent;

    protected static string|\UnitEnum|null $navigationGroup = 'Pharmacy';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'batch_number';

    public static function form(Schema $schema): Schema
    {
        return DrugBatchForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DrugBatchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DrugBatchesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDrugBatches::route('/'),
            'create' => CreateDrugBatch::route('/create'),
            'view'   => ViewDrugBatch::route('/{record}'),
            'edit'   => EditDrugBatch::route('/{record}/edit'),
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
