<?php

namespace App\Filament\Resources\Receipts\Schemas;

use Filament\Schemas\Schema;

use App\Models\Drug;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;


class ReceiptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Source')
                    ->schema([
                        Select::make('purchase_id')
                            ->label('Purchase order')
                            ->relationship('purchase', 'purchase_number')
                            ->searchable()
                            ->preload(),
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->relationship('supplier', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('invoice_number')
                            ->label('Invoice number')
                            ->maxLength(120),
                        TextInput::make('delivery_note_number')
                            ->label('Delivery note number')
                            ->maxLength(120),
                    ])->columns(2),

                Section::make('Receipt')
                    ->schema([
                        DatePicker::make('received_date')
                            ->label('Received date')
                            ->default(today())
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Pending' => 'Pending',
                                'Verified' => 'Verified',
                                'Rejected' => 'Rejected',
                            ])
                            ->default('Pending')
                            ->required(),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

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
                                            $set('unit_cost', $drug->cost_price);
                                        }
                                    }),
                                TextInput::make('batch_number')
                                    ->label('Batch number')
                                    ->maxLength(120),
                                DatePicker::make('expiry_date')
                                    ->label('Expiry date'),
                                TextInput::make('quantity_received')
                                    ->label('Quantity received')
                                    ->numeric()
                                    ->default(0)
                                    ->step(0.01),
                                TextInput::make('quantity_rejected')
                                    ->label('Quantity rejected')
                                    ->numeric()
                                    ->default(0)
                                    ->step(0.01),
                                TextInput::make('unit_cost')
                                    ->label('Unit cost')
                                    ->numeric()
                                    ->prefix('NGN')
                                    ->step(0.01)
                                    ->default(0),
                                Textarea::make('notes')
                                    ->label('Notes')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add item'),
                    ]),
            ]);
    }
}
