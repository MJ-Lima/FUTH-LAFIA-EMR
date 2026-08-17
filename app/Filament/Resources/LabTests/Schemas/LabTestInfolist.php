<?php

namespace App\Filament\Resources\LabTests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LabTestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('LabTest Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Test'),
                        TextEntry::make('panel.name')->label('Panel'),
                        TextEntry::make('loinc_code')->label('LOINC'),
                        TextEntry::make('unit')->label('Unit'),
                        TextEntry::make('price')->label('Price'),
                        TextEntry::make('status')->label('Active'),
                    ])
                    ->columns(2),
            ]);
    }
}
