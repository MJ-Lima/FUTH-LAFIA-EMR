<?php

namespace App\Filament\Resources\DrugInteractions\Tables;

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

class DrugInteractionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('drugA.name')
                    ->label('Drug A')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('drugB.name')
                    ->label('Drug B')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('severity')
                    ->label('Severity')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Contraindicated' => 'danger',
                        'Major' => 'danger',
                        'Moderate' => 'warning',
                        'Minor' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('effect')
                    ->label('Effect')
                    ->badge(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(60),
                TextColumn::make('source')
                    ->label('Source')
                    ->toggleable(),
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
                SelectFilter::make('severity')
                    ->label('Severity')
                    ->options([
                        'Minor' => 'Minor',
                        'Moderate' => 'Moderate',
                        'Major' => 'Major',
                        'Contraindicated' => 'Contraindicated',
                    ]),
                SelectFilter::make('drug_a_id')
                    ->label('Drug A')
                    ->relationship('drugA', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('drug_b_id')
                    ->label('Drug B')
                    ->relationship('drugB', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('status')
                    ->label('Active'),
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
