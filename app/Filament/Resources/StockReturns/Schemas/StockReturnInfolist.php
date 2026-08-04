<?php

namespace App\Filament\Resources\StockReturns\Schemas;

use Filament\Schemas\Schema;


use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class StockReturnInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Return')
                    ->schema([
                        TextEntry::make('return_number')->label('Return #'),
                        TextEntry::make('returned_at')->label('Returned at')->dateTime(),
                        TextEntry::make('quantity')->label('Quantity'),
                        TextEntry::make('reason')
                            ->label('Reason')
                            ->badge(),
                        TextEntry::make('disposition')
                            ->label('Disposition')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Restocked' => 'success',
                                'Quarantined' => 'warning',
                                'Disposed' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('receiver.name')->label('Received by'),
                        TextEntry::make('notes')->label('Notes')->columnSpanFull(),
                    ])->columns(3),

                Section::make('Source')
                    ->schema([
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('patient.patientcode')->label('Patient code'),
                        TextEntry::make('dispensingLog.reference_number')->label('Dispensing log'),
                        TextEntry::make('drug.name')->label('Drug'),
                        TextEntry::make('batch.batch_number')->label('Batch'),
                    ])->columns(3),
            ]);
    }
}
