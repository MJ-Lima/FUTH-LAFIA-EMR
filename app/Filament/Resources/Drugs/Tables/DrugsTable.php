<?php

namespace App\Filament\Resources\Drugs\Tables;

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

class DrugsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Brand name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('generic_name')
                    ->label('Generic name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                TextColumn::make('dosage_form')
                    ->label('Form')
                    ->toggleable(),
                TextColumn::make('strength')
                    ->label('Strength'),
                TextColumn::make('manufacturer')
                    ->label('Manufacturer')
                    ->toggleable(),
                TextColumn::make('selling_price')
                    ->label('Selling price')
                    ->money('NGN')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label('Stock')
                    ->state(fn ($record) => $record->currentStock())
                    ->suffix(' units'),
                IconColumn::make('is_below_reorder')
                    ->label('Low stock')
                    ->boolean()
                    ->state(fn ($record) => $record->isBelowReorder()),
                IconColumn::make('status')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('drug_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('status')
                    ->label('Active'),
                TernaryFilter::make('is_controlled')
                    ->label('Controlled substance'),
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
