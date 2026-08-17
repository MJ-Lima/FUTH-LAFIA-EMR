<?php

namespace App\Filament\Resources\BedTransfers;

use App\Filament\Resources\BedTransfers\Pages\CreateBedTransfer;
use App\Filament\Resources\BedTransfers\Pages\EditBedTransfer;
use App\Filament\Resources\BedTransfers\Pages\ListBedTransfers;
use App\Filament\Resources\BedTransfers\Pages\ViewBedTransfer;
use App\Filament\Resources\BedTransfers\Schemas\BedTransferForm;
use App\Filament\Resources\BedTransfers\Schemas\BedTransferInfolist;
use App\Filament\Resources\BedTransfers\Tables\BedTransfersTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\BedTransfer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BedTransferResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = BedTransfer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static string|\UnitEnum|null $navigationGroup = 'Ward & Bed Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'transfer_number';

    public static function form(Schema $schema): Schema
    {
        return BedTransferForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BedTransferInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BedTransfersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBedTransfers::route('/'),
            'create' => CreateBedTransfer::route('/create'),
            'view'   => ViewBedTransfer::route('/{record}'),
            'edit'   => EditBedTransfer::route('/{record}/edit'),
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
