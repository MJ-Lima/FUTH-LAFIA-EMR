<?php

namespace App\Filament\Resources\DrugInteractions\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class DrugInteractionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Drug Pair')
                    ->schema([
                        TextEntry::make('drugA.name')->label('Drug A'),
                        TextEntry::make('drugB.name')->label('Drug B'),
                    ])->columns(2),

                Section::make('Interaction')
                    ->schema([
                        TextEntry::make('severity')
                            ->label('Severity')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Contraindicated' => 'danger',
                                'Major' => 'danger',
                                'Moderate' => 'warning',
                                'Minor' => 'gray',
                                default => 'gray',
                            }),
                        TextEntry::make('effect')
                            ->label('Effect')
                            ->badge(),
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                        TextEntry::make('clinical_action')
                            ->label('Clinical action')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Source')
                    ->schema([
                        TextEntry::make('source')->label('Source'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->state(fn ($record) => $record->status ? 'Active' : 'Inactive')
                            ->color(fn ($state) => $state === 'Active' ? 'success' : 'gray'),
                    ])->columns(2),
            ]);
    }
}
