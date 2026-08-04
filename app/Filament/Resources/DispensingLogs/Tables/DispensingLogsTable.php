<?php

namespace App\Filament\Resources\DispensingLogs\Tables;

use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DispensingLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')
                    ->label('Ref #')
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
                TextColumn::make('drug.name')
                    ->label('Drug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('batch.batch_number')
                    ->label('Batch')
                    ->toggleable(),
                TextColumn::make('dispensingPoint.name')
                    ->label('Point')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Qty')
                    ->sortable(),
                TextColumn::make('unit_price')
                    ->label('Unit price')
                    ->money('NGN')
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('NGN')
                    ->sortable(),
                TextColumn::make('dispensed_at')
                    ->label('Dispensed at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('dispenser.name')
                    ->label('Dispensed by')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('dispensing_point_id')
                    ->label('Dispensing point')
                    ->relationship('dispensingPoint', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('drug_id')
                    ->label('Drug')
                    ->relationship('drug', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('patient_id')
                    ->label('Patient')
                    ->relationship('patient', 'patientcode')
                    ->searchable()
                    ->preload(),
                Filter::make('dispensed_at')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $d) => $q->whereDate('dispensed_at', '>=', $d))
                            ->when($data['until'], fn ($q, $d) => $q->whereDate('dispensed_at', '<=', $d));
                    }),
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
