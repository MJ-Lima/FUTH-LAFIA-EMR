<?php

namespace App\Filament\Resources\Encounters\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EncountersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hospital.code')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('patient.patientcode')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('clinic.name')
                    ->numeric()
                    ->sortable(),
              
                TextColumn::make('encounter_number')
                    ->searchable(),
                TextColumn::make('visit_type')
                    ->badge(),
                
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('appointment_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
