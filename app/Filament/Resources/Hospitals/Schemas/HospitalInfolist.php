<?php

namespace App\Filament\Resources\Hospitals\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;


class HospitalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('code'),
                IconEntry::make('status')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
