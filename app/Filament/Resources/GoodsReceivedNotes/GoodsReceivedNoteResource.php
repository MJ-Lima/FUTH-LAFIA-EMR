<?php

namespace App\Filament\Resources\GoodsReceivedNotes;

use App\Filament\Resources\GoodsReceivedNotes\Pages\CreateGoodsReceivedNote;
use App\Filament\Resources\GoodsReceivedNotes\Pages\EditGoodsReceivedNote;
use App\Filament\Resources\GoodsReceivedNotes\Pages\ListGoodsReceivedNotes;
use App\Filament\Resources\GoodsReceivedNotes\Pages\ViewGoodsReceivedNote;
use App\Filament\Resources\GoodsReceivedNotes\Schemas\GoodsReceivedNoteForm;
use App\Filament\Resources\GoodsReceivedNotes\Schemas\GoodsReceivedNoteInfolist;
use App\Filament\Resources\GoodsReceivedNotes\Tables\GoodsReceivedNotesTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\GoodsReceivedNote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GoodsReceivedNoteResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = GoodsReceivedNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static string|\UnitEnum|null $navigationGroup = 'Pharmacy';

    protected static ?int $navigationSort = 9;

    protected static ?string $recordTitleAttribute = 'grn_number';

    public static function form(Schema $schema): Schema
    {
        return GoodsReceivedNoteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GoodsReceivedNoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GoodsReceivedNotesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListGoodsReceivedNotes::route('/'),
            'create' => CreateGoodsReceivedNote::route('/create'),
            'view'   => ViewGoodsReceivedNote::route('/{record}'),
            'edit'   => EditGoodsReceivedNote::route('/{record}/edit'),
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
