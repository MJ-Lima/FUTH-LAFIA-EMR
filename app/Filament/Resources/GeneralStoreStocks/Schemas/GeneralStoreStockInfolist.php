<?php
namespace App\Filament\Resources\GeneralStoreStocks\Schemas;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
class GeneralStoreStockInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([Section::make('GeneralStoreStock Information')->schema([
                        TextEntry::make('item.name')->label('Item'),
                        TextEntry::make('location.name')->label('Location'),
                        TextEntry::make('batch_number')->label('Batch'),
                        TextEntry::make('expiry_date')->label('Expiry')->date(),
                        TextEntry::make('quantity_remaining')->label('Remaining'),
                        TextEntry::make('unit_cost')->label('Unit Cost'),
                        TextEntry::make('is_quarantined')->label('Quarantined'),
        ])->columns(2)]);
    }
}
