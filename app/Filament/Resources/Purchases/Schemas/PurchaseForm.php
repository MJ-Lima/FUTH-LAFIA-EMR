<?php

namespace App\Filament\Resources\Purchases\Schemas;

use Filament\Schemas\Schema;

use App\Models\Drug;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;


class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        $recalcLine = function ($get, $set): void {
            $qty = (float) ($get('quantity_ordered') ?? 0);
            $cost = (float) ($get('unit_cost') ?? 0);
            $taxPct = (float) ($get('tax_percent') ?? 0);
            $discPct = (float) ($get('discount_percent') ?? 0);
            $lineSub = $qty * $cost;
            $discount = $lineSub * ($discPct / 100);
            $taxable = $lineSub - $discount;
            $tax = $taxable * ($taxPct / 100);
            $set('line_total', round($taxable + $tax, 2));
        };

        $recalcTotals = function ($state, $set): void {
            $subtotal = 0.0;
            $taxAmount = 0.0;
            $discountAmount = 0.0;
            foreach (($state ?? []) as $item) {
                $qty = (float) ($item['quantity_ordered'] ?? 0);
                $cost = (float) ($item['unit_cost'] ?? 0);
                $taxPct = (float) ($item['tax_percent'] ?? 0);
                $discPct = (float) ($item['discount_percent'] ?? 0);
                $lineSub = $qty * $cost;
                $discount = $lineSub * ($discPct / 100);
                $taxable = $lineSub - $discount;
                $tax = $taxable * ($taxPct / 100);
                $subtotal += $lineSub;
                $taxAmount += $tax;
                $discountAmount += $discount;
            }
            $set('subtotal', round($subtotal, 2));
            $set('tax_amount', round($taxAmount, 2));
            $set('discount_amount', round($discountAmount, 2));
            $set('total_amount', round($subtotal - $discountAmount + $taxAmount, 2));
        };

        return $schema
            ->components([
                Section::make('Supplier & Reference')
                    ->schema([
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->relationship('supplier', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('invoice_number')
                            ->label('Invoice number')
                            ->maxLength(120),
                        TextInput::make('lpo_number')
                            ->label('LPO number')
                            ->maxLength(120),
                    ])->columns(3),

                Section::make('Dates')
                    ->schema([
                        DatePicker::make('order_date')
                            ->label('Order date')
                            ->default(today()),
                        DatePicker::make('received_date')
                            ->label('Received date'),
                        DatePicker::make('invoice_date')
                            ->label('Invoice date'),
                    ])->columns(3),

                Section::make('Items')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('drug_id')
                                    ->label('Drug')
                                    ->relationship('drug', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $drug = Drug::find($state);
                                        if ($drug) {
                                            $set('drug_name', $drug->name);
                                            $set('unit_cost', $drug->cost_price);
                                        }
                                    }),
                                TextInput::make('drug_name')
                                    ->label('Drug name')
                                    ->disabled()
                                    ->dehydrated(),
                                TextInput::make('batch_number')
                                    ->label('Batch number')
                                    ->maxLength(120),
                                DatePicker::make('expiry_date')
                                    ->label('Expiry date'),
                                TextInput::make('quantity_ordered')
                                    ->label('Quantity ordered')
                                    ->numeric()
                                    ->default(0)
                                    ->step(0.01)
                                    ->live()
                                    ->afterStateUpdated($recalcLine),
                                TextInput::make('quantity_received')
                                    ->label('Quantity received')
                                    ->numeric()
                                    ->default(0)
                                    ->step(0.01),
                                TextInput::make('unit_cost')
                                    ->label('Unit cost')
                                    ->numeric()
                                    ->default(0)
                                    ->step(0.01)
                                    ->prefix('NGN')
                                    ->live()
                                    ->afterStateUpdated($recalcLine),
                                TextInput::make('tax_percent')
                                    ->label('Tax %')
                                    ->numeric()
                                    ->default(0)
                                    ->step(0.01)
                                    ->live()
                                    ->afterStateUpdated($recalcLine),
                                TextInput::make('discount_percent')
                                    ->label('Discount %')
                                    ->numeric()
                                    ->default(0)
                                    ->step(0.01)
                                    ->live()
                                    ->afterStateUpdated($recalcLine),
                                TextInput::make('line_total')
                                    ->label('Line total')
                                    ->numeric()
                                    ->prefix('NGN')
                                    ->disabled()
                                    ->dehydrated(),
                            ])
                            ->columns(2)
                            ->live()
                            ->afterStateUpdated($recalcTotals)
                            ->addActionLabel('Add item'),
                    ]),

                Section::make('Totals & Status')
                    ->schema([
                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->prefix('NGN')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('tax_amount')
                            ->label('Tax amount')
                            ->numeric()
                            ->prefix('NGN')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('discount_amount')
                            ->label('Discount amount')
                            ->numeric()
                            ->prefix('NGN')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('total_amount')
                            ->label('Total amount')
                            ->numeric()
                            ->prefix('NGN')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('amount_paid')
                            ->label('Amount paid')
                            ->numeric()
                            ->prefix('NGN')
                            ->step(0.01)
                            ->default(0),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Draft' => 'Draft',
                                'Ordered' => 'Ordered',
                                'Partially Received' => 'Partially Received',
                                'Received' => 'Received',
                                'Cancelled' => 'Cancelled',
                            ])
                            ->default('Draft')
                            ->required(),
                        Select::make('payment_status')
                            ->label('Payment status')
                            ->options([
                                'Unpaid' => 'Unpaid',
                                'Partially Paid' => 'Partially Paid',
                                'Paid' => 'Paid',
                            ])
                            ->default('Unpaid'),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
