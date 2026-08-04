<?php

namespace App\Filament\Resources\Prescriptions\Tables;

use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PrescriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prescription_number')
                    ->label('Rx #')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(['firstname', 'lastname'])
                    ->sortable(),
                TextColumn::make('patient.patientcode')
                    ->label('Patient code')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('prescriber.name')
                    ->label('Prescriber')
                    ->sortable(),
                TextColumn::make('dispensingPoint.name')
                    ->label('Point')
                    ->toggleable(),
                TextColumn::make('prescribed_at')
                    ->label('Prescribed at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('dispensed_at')
                    ->label('Dispensed at')
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'STAT' => 'danger',
                        'Urgent' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Dispensed' => 'success',
                        'Partially Dispensed' => 'warning',
                        'Pending' => 'gray',
                        'Cancelled' => 'danger',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
                IconColumn::make('is_inpatient')
                    ->label('Inpatient')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Partially Dispensed' => 'Partially Dispensed',
                        'Dispensed' => 'Dispensed',
                        'Cancelled' => 'Cancelled',
                        'Rejected' => 'Rejected',
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'Routine' => 'Routine',
                        'Urgent' => 'Urgent',
                        'STAT' => 'STAT',
                    ]),
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
