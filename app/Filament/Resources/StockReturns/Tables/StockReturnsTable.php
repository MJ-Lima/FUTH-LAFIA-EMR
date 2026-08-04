<?php

namespace App\Filament\Resources\StockReturns\Tables;

use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StockReturnsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('return_number')
                    ->label('Return #')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(['firstname', 'lastname'])
                    ->toggleable(),
                TextColumn::make('drug.name')
                    ->label('Drug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('batch.batch_number')
                    ->label('Batch')
                    ->toggleable(),
                TextColumn::make('returned_at')
                    ->label('Returned at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Qty')
                    ->sortable(),
                TextColumn::make('reason')
                    ->label('Reason')
                    ->badge(),
                TextColumn::make('disposition')
                    ->label('Disposition')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Restocked' => 'success',
                        'Quarantined' => 'warning',
                        'Disposed' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('receiver.name')
                    ->label('Received by')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('reason')
                    ->options([
                        'Expired' => 'Expired',
                        'Damaged' => 'Damaged',
                        'Wrong Dispense' => 'Wrong Dispense',
                        'Patient Returned' => 'Patient Returned',
                        'Other' => 'Other',
                    ]),
                SelectFilter::make('disposition')
                    ->options([
                        'Restocked' => 'Restocked',
                        'Quarantined' => 'Quarantined',
                        'Disposed' => 'Disposed',
                    ]),
                SelectFilter::make('drug_id')
                    ->label('Drug')
                    ->relationship('drug', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
