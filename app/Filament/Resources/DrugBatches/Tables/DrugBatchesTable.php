<?php

namespace App\Filament\Resources\DrugBatches\Tables;

use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class DrugBatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('drug.name')
                    ->label('Drug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('batch_number')
                    ->label('Batch #')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('expiry_date')
                    ->label('Expiry')
                    ->date()
                    ->sortable()
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
                TextColumn::make('quantity_received')
                    ->label('Received')
                    ->sortable(),
                TextColumn::make('quantity_remaining')
                    ->label('Remaining')
                    ->sortable(),
                TextColumn::make('cost_price')
                    ->label('Cost price')
                    ->money('NGN')
                    ->sortable(),
                IconColumn::make('is_quarantined')
                    ->label('Quarantined')
                    ->boolean(),
                TextColumn::make('received_date')
                    ->label('Received on')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('drug_id')
                    ->label('Drug')
                    ->relationship('drug', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_quarantined')
                    ->label('Quarantined'),
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
