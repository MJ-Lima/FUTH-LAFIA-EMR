<?php

namespace App\Filament\Resources\LabPanels\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LabPanelInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('LabPanel Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Panel'),
                        TextEntry::make('loinc_code')->label('LOINC'),
                        TextEntry::make('specimen_type')->label('Specimen'),
                        TextEntry::make('price')->label('Price'),
                        TextEntry::make('turnaround_hours')->label('TAT (hrs)'),
                        TextEntry::make('status')->label('Active'),
                    ])
                    ->columns(2),
            ]);
    }
}
