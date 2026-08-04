<?php

namespace App\Filament\Resources\DispensingPoints\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class DispensingPointInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dispensing Point')
                    ->schema([
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('location')->label('Location'),
                        TextEntry::make('inCharge.name')->label('In-charge'),
                        IconEntry::make('status')
                            ->label('Active')
                            ->boolean(),
                    ])->columns(2),
            ]);
    }
}
