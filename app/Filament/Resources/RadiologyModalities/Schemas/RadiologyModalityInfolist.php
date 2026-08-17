<?php

namespace App\Filament\Resources\RadiologyModalities\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RadiologyModalityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('RadiologyModality Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Modality'),
                        TextEntry::make('price')->label('Price'),
                        TextEntry::make('turnaround_hours')->label('TAT'),
                        TextEntry::make('status')->label('Active'),
                    ])
                    ->columns(2),
            ]);
    }
}
