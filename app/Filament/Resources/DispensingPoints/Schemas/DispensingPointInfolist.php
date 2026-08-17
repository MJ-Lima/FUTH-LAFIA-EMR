<?php

namespace App\Filament\Resources\DispensingPoints\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DispensingPointInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('DispensingPoint Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Point'),
                        TextEntry::make('location')->label('Location'),
                        TextEntry::make('inCharge.name')->label('In-Charge'),
                        TextEntry::make('status')->label('Active'),
                    ])
                    ->columns(2),
            ]);
    }
}
