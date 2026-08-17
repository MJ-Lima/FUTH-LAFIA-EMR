<?php
namespace App\Filament\Resources\GeneralStoreItems\Schemas;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
class GeneralStoreItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([Section::make('GeneralStoreItem Information')->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Item Name'),
                        TextEntry::make('category.name')->label('Category'),
                        TextEntry::make('unit_of_measure')->label('UoM'),
                        TextEntry::make('cost_price')->label('Cost'),
                        TextEntry::make('selling_price')->label('Selling'),
                        TextEntry::make('is_consumable')->label('Consumable'),
                        TextEntry::make('is_active')->label('Active'),
        ])->columns(2)]);
    }
}
