<?php

namespace App\Filament\Resources\RadiologyModalities\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class RadiologyModalityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Modality Information')
                    ->schema([
                        TextEntry::make('name')->label('Modality name'),
                        TextEntry::make('code')
                            ->label('Code')
                            ->badge(),
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
