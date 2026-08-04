<?php

namespace App\Filament\Resources\StockMovements\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class StockMovementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Movement')
                    ->schema([
                        TextEntry::make('movement_date')->label('Date')->dateTime(),
                        TextEntry::make('type')
                            ->label('Type')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Receipt' => 'success',
                                'Transfer In' => 'info',
                                'Transfer Out' => 'warning',
                                'Dispense' => 'warning',
                                'Adjustment In' => 'success',
                                'Adjustment Out' => 'danger',
                                'Return' => 'info',
                                'Disposal' => 'danger',
                                'Stock Take' => 'gray',
                                default => 'gray',
                            }),
                        TextEntry::make('reference_number')->label('Reference #'),
                        TextEntry::make('quantity')
                            ->label('Quantity')
                            ->color(fn ($state): string => (float) $state >= 0 ? 'success' : 'danger'),
                        TextEntry::make('balance_after')->label('Balance after'),
                        TextEntry::make('user.name')->label('By'),
                        TextEntry::make('reason')->label('Reason')->columnSpanFull(),
                    ])->columns(3),

                Section::make('Item')
                    ->schema([
                        TextEntry::make('drug.name')->label('Drug'),
                        TextEntry::make('batch.batch_number')->label('Batch'),
                        TextEntry::make('dispensingPoint.name')->label('Dispensing point'),
                    ])->columns(3),
            ]);
    }
}
