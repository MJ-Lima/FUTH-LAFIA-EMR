<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Service'),
                        TextEntry::make('category')->label('Category'),
                        TextEntry::make('standard_price')->label('Std Price'),
                        TextEntry::make('nhia_rate')->label('NHIA Rate'),
                        TextEntry::make('private_rate')->label('Private Rate'),
                        TextEntry::make('status')->label('Status'),
                    ])
                    ->columns(2),
            ]);
    }
}
