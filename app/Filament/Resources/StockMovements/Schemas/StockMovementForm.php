<?php

namespace App\Filament\Resources\StockMovements\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;


class StockMovementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Item')
                    ->schema([
                        Select::make('drug_id')
                            ->label('Drug')
                            ->relationship('drug', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('drug_batch_id')
                            ->label('Batch')
                            ->relationship('batch', 'batch_number')
                            ->searchable()
                            ->preload(),
                        Select::make('dispensing_point_id')
                            ->label('Dispensing point')
                            ->relationship('dispensingPoint', 'name')
                            ->searchable()
                            ->preload(),
                    ])->columns(3),

                Section::make('Movement')
                    ->schema([
                        Select::make('type')
                            ->label('Type')
                            ->options([
                                'Receipt' => 'Receipt',
                                'Transfer In' => 'Transfer In',
                                'Transfer Out' => 'Transfer Out',
                                'Dispense' => 'Dispense',
                                'Adjustment In' => 'Adjustment In',
                                'Adjustment Out' => 'Adjustment Out',
                                'Return' => 'Return',
                                'Disposal' => 'Disposal',
                                'Stock Take' => 'Stock Take',
                            ])
                            ->required(),
                        TextInput::make('reference_number')
                            ->label('Reference #')
                            ->maxLength(120),
                        DateTimePicker::make('movement_date')
                            ->label('Movement date')
                            ->default(now())
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Quantity (negative for out)')
                            ->numeric()
                            ->required()
                            ->step(0.01)
                            ->helperText('Positive for inward movements, negative for outward movements.'),
                        TextInput::make('balance_after')
                            ->label('Balance after')
                            ->numeric()
                            ->step(0.01),
                        Textarea::make('reason')
                            ->label('Reason')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
