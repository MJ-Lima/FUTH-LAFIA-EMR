<?php

namespace App\Filament\Resources\InsuranceProviders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InsuranceProviderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('InsuranceProvider Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Provider'),
                        TextEntry::make('short_name')->label('Short Name'),
                        TextEntry::make('type')->label('Type'),
                        TextEntry::make('contact_person')->label('Contact'),
                        TextEntry::make('phone')->label('Phone'),
                        TextEntry::make('status')->label('Status'),
                    ])
                    ->columns(2),
            ]);
    }
}
