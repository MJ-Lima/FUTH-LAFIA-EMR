<?php
namespace App\Filament\Resources\GeneralStoreLocations\Schemas;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
class GeneralStoreLocationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([Section::make('GeneralStoreLocation Information')->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Location'),
                        TextEntry::make('type')->label('Type'),
                        TextEntry::make('department.name')->label('Department'),
                        TextEntry::make('building')->label('Building'),
                        TextEntry::make('floor')->label('Floor'),
                        TextEntry::make('inCharge.name')->label('In-Charge'),
                        TextEntry::make('is_active')->label('Active'),
        ])->columns(2)]);
    }
}
