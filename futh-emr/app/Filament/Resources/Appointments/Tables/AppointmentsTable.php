<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('appointment_number')->label('Appt #')->searchable(),
                    TextColumn::make('patient.full_name')->label('Patient')->sortable(),
                    TextColumn::make('clinic.name')->label('Clinic')->sortable(),
                    TextColumn::make('provider.name')->label('Provider')->sortable(),
                    TextColumn::make('appointment_date')->label('Date')->date()->searchable(),
                    TextColumn::make('appointment_time')->label('Time')->searchable(),
                    TextColumn::make('visit_type')->label('Type')->badge()->color('success')->searchable(),
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
