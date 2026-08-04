<?php

namespace App\Filament\Resources\Purchases\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class PurchaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Supplier & Reference')
                    ->schema([
                        TextEntry::make('purchase_number')->label('PO #'),
                        TextEntry::make('supplier.name')->label('Supplier'),
                        TextEntry::make('invoice_number')->label('Invoice #'),
                        TextEntry::make('lpo_number')->label('LPO #'),
                    ])->columns(2),

                Section::make('Dates')
                    ->schema([
                        TextEntry::make('order_date')->label('Order date')->date(),
                        TextEntry::make('received_date')->label('Received date')->date(),
                        TextEntry::make('invoice_date')->label('Invoice date')->date(),
                    ])->columns(3),

                Section::make('Items')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                TextEntry::make('drug_name')->label('Drug'),
                                TextEntry::make('batch_number')->label('Batch #'),
                                TextEntry::make('expiry_date')->label('Expiry')->date(),
                                TextEntry::make('quantity_ordered')->label('Qty ordered'),
                                TextEntry::make('quantity_received')->label('Qty received'),
                                TextEntry::make('unit_cost')->label('Unit cost')->money('NGN'),
                                TextEntry::make('tax_percent')->label('Tax %'),
                                TextEntry::make('discount_percent')->label('Disc %'),
                                TextEntry::make('line_total')->label('Line total')->money('NGN'),
                            ])
                            ->columns(3),
                    ]),

                Section::make('Totals & Status')
                    ->schema([
                        TextEntry::make('subtotal')->label('Subtotal')->money('NGN'),
                        TextEntry::make('tax_amount')->label('Tax amount')->money('NGN'),
                        TextEntry::make('discount_amount')->label('Discount amount')->money('NGN'),
                        TextEntry::make('total_amount')->label('Total amount')->money('NGN'),
                        TextEntry::make('amount_paid')->label('Amount paid')->money('NGN'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Draft' => 'gray',
                                'Ordered' => 'info',
                                'Partially Received' => 'warning',
                                'Received' => 'success',
                                'Cancelled' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('payment_status')
                            ->label('Payment status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Paid' => 'success',
                                'Partially Paid' => 'warning',
                                'Unpaid' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('receiver.name')->label('Received by'),
                        TextEntry::make('notes')->columnSpanFull(),
                    ])->columns(3),
            ]);
    }
}
