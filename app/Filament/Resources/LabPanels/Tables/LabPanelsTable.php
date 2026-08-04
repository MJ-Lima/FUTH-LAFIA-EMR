<?php

namespace App\Filament\Resources\LabPanels\Tables;

use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class LabPanelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Panel')
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
                TextColumn::make('specimen_type')
                    ->label('Specimen')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('container')
                    ->label('Container')
                    ->toggleable(),
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
