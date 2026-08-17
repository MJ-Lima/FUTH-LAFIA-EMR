<?php

namespace App\Filament\Resources\StockTakes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StockTakeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('StockTake Information')
                    ->schema([
                        TextEntry::make('stock_take_number')->label('STK #'),
                        TextEntry::make('scope')->label('Scope'),
                        TextEntry::make('location.name')->label('Location'),
                        TextEntry::make('stock_take_date')->label('Date')->date(),
                        TextEntry::make('status')->label('Status'),
                        TextEntry::make('initiator.name')->label('Initiated By'),
                    ])
                    ->columns(2),
            ]);
    }
}
