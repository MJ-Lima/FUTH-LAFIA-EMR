<?php

namespace App\Filament\Resources\StockMovements\Tables;

use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StockMovementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('movement_date')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('drug.name')
                    ->label('Drug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('batch.batch_number')
                    ->label('Batch')
                    ->toggleable(),
                TextColumn::make('dispensingPoint.name')
                    ->label('Point')
                    ->toggleable(),
                TextColumn::make('type')
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
                TextColumn::make('reference_number')
                    ->label('Ref #')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('quantity')
                    ->label('Qty')
                    ->sortable()
                    ->color(fn ($state): string => (float) $state >= 0 ? 'success' : 'danger'),
                TextColumn::make('balance_after')
                    ->label('Balance after')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('By')
                    ->sortable(),
                TextColumn::make('reason')
                    ->label('Reason')
                    ->limit(60)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
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
                    ]),
                SelectFilter::make('drug_id')
                    ->label('Drug')
                    ->relationship('drug', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('dispensing_point_id')
                    ->label('Dispensing point')
                    ->relationship('dispensingPoint', 'name')
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
