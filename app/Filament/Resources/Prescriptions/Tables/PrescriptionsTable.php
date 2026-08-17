<?php

namespace App\Filament\Resources\Prescriptions\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class PrescriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('prescription_number')->label('RX #')->searchable(),
                    TextColumn::make('patient.full_name')->label('Patient')->sortable(),
                    TextColumn::make('prescriber.name')->label('Prescriber')->sortable(),
                    TextColumn::make('dispensingPoint.name')->label('Dispensing Point')->sortable(),
                    TextColumn::make('prescribed_at')->label('Prescribed')->dateTime()->searchable(),
                    TextColumn::make('priority')->label('Priority')->badge()->color('success')->searchable(),
                    TextColumn::make('status')->label('Status')->badge()->color('success')->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
