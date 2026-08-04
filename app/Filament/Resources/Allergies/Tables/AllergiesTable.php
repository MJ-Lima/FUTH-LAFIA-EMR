<?php

namespace App\Filament\Resources\Allergies\Tables;

use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AllergiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(['firstname', 'lastname'])
                    ->sortable(),
                TextColumn::make('patient.patientcode')
                    ->label('Patient code')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('substance')
                    ->label('Substance')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->sortable(),
                TextColumn::make('severity')
                    ->label('Severity')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Fatal' => 'danger',
                        'Severe' => 'danger',
                        'Moderate' => 'warning',
                        'Mild' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('criticality')
                    ->label('Criticality')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'High' => 'danger',
                        'Low' => 'gray',
                        'Unable to assess' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('reaction')
                    ->label('Reaction')
                    ->toggleable(),
                TextColumn::make('onset_date')
                    ->label('Onset')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Resolved' => 'gray',
                        'Inactive' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('recorder.name')
                    ->label('Recorded by')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'Medication' => 'Medication',
                        'Food' => 'Food',
                        'Environment' => 'Environment',
                        'Biologic' => 'Biologic',
                        'Other' => 'Other',
                    ]),
                SelectFilter::make('severity')
                    ->options([
                        'Mild' => 'Mild',
                        'Moderate' => 'Moderate',
                        'Severe' => 'Severe',
                        'Fatal' => 'Fatal',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'Active' => 'Active',
                        'Resolved' => 'Resolved',
                        'Inactive' => 'Inactive',
                    ]),
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
