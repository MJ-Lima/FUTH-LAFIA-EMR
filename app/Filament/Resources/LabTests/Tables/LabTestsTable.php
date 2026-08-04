<?php

namespace App\Filament\Resources\LabTests\Tables;

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

class LabTestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Test')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('loinc_code')
                    ->label('LOINC')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('panel.name')
                    ->label('Panel')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('specimen_type')
                    ->label('Specimen')
                    ->toggleable(),
                TextColumn::make('unit')
                    ->label('Unit')
                    ->toggleable(),
                TextColumn::make('reference_range')
                    ->label('Reference range')
                    ->state(fn ($record) => $record->reference_range_low !== null && $record->reference_range_high !== null
                        ? "{$record->reference_range_low} - {$record->reference_range_high}"
                        : null),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('NGN')
                    ->sortable(),
                TextColumn::make('turnaround_hours')
                    ->label('Turnaround')
                    ->suffix(' hrs')
                    ->sortable(),
                IconColumn::make('status')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('lab_panel_id')
                    ->label('Lab panel')
                    ->relationship('panel', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('status')
                    ->label('Active')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
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
