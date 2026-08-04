<?php

namespace App\Filament\Resources\LabPanels\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class LabPanelInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Panel Information')
                    ->schema([
                        TextEntry::make('name')->label('Panel name'),
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('loinc_code')->label('LOINC code'),
                        TextEntry::make('specimen_type')->label('Specimen type'),
                        TextEntry::make('container')->label('Container'),
                        TextEntry::make('price')->label('Price')->money('NGN'),
                        TextEntry::make('turnaround_hours')->label('Turnaround')->suffix(' hrs'),
                        TextEntry::make('status')
                            ->label('Active')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                            ->color(fn ($state) => $state ? 'success' : 'gray'),
                        TextEntry::make('description')->columnSpanFull(),
                    ])->columns(3),
            ]);
    }
}
