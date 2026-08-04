<?php

namespace App\Filament\Resources\DrugBatches\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class DrugBatchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Batch Information')
                    ->schema([
                        TextEntry::make('drug.name')->label('Drug'),
                        TextEntry::make('batch_number')->label('Batch number'),
                        TextEntry::make('expiry_date')
                            ->label('Expiry date')
                            ->date()
                            ->color(function ($record): ?string {
                                if (! $record->expiry_date) {
                                    return null;
                                }
                                if ($record->expiry_date->isPast()) {
                                    return 'danger';
                                }
                                if ($record->expiry_date->lessThanOrEqualTo(now()->addDays(90))) {
                                    return 'warning';
                                }
                                return 'gray';
                            }),
                        TextEntry::make('manufactured_date')
                            ->label('Manufactured date')
                            ->date(),
                    ])->columns(2),

                Section::make('Quantity')
                    ->schema([
                        TextEntry::make('quantity_received')->label('Quantity received'),
                        TextEntry::make('quantity_remaining')->label('Quantity remaining'),
                        TextEntry::make('cost_price')->label('Cost price')->money('NGN'),
                    ])->columns(3),

                Section::make('Supplier')
                    ->schema([
                        TextEntry::make('supplier')->label('Supplier'),
                        TextEntry::make('received_date')->label('Received date')->date(),
                        TextEntry::make('is_quarantined')
                            ->label('Quarantined')
                            ->badge()
                            ->state(fn ($record) => $record->is_quarantined ? 'Yes' : 'No')
                            ->color(fn ($state) => $state === 'Yes' ? 'danger' : 'success'),
                    ])->columns(3),
            ]);
    }
}
