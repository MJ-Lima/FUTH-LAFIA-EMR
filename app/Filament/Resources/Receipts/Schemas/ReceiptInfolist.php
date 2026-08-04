<?php

namespace App\Filament\Resources\Receipts\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class ReceiptInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Source')
                    ->schema([
                        TextEntry::make('receipt_number')->label('Receipt #'),
                        TextEntry::make('purchase.purchase_number')->label('Purchase #'),
                        TextEntry::make('supplier.name')->label('Supplier'),
                        TextEntry::make('invoice_number')->label('Invoice #'),
                        TextEntry::make('delivery_note_number')->label('Delivery note #'),
                    ])->columns(2),

                Section::make('Receipt')
                    ->schema([
                        TextEntry::make('received_date')->label('Received date')->date(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Verified' => 'success',
                                'Pending' => 'warning',
                                'Rejected' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('receiver.name')->label('Received by'),
                        TextEntry::make('notes')->columnSpanFull(),
                    ])->columns(2),

                Section::make('Items')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                TextEntry::make('drug.name')->label('Drug'),
                                TextEntry::make('batch_number')->label('Batch #'),
                                TextEntry::make('expiry_date')->label('Expiry')->date(),
                                TextEntry::make('quantity_received')->label('Qty received'),
                                TextEntry::make('quantity_rejected')->label('Qty rejected'),
                                TextEntry::make('unit_cost')->label('Unit cost')->money('NGN'),
                                TextEntry::make('notes')->label('Notes'),
                            ])
                            ->columns(3),
                    ]),
            ]);
    }
}
