<?php

namespace App\Filament\Resources\PatientInsurance\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class PatientInsuranceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('policy_number')->label('Policy #')->searchable(),
                    TextColumn::make('patient.full_name')->label('Patient')->sortable(),
                    TextColumn::make('provider.name')->label('Provider')->sortable(),
                    TextColumn::make('plan.name')->label('Plan')->sortable(),
                    TextColumn::make('principal_relationship')->label('Relationship')->badge()->color('success')->searchable(),
                    TextColumn::make('effective_date')->label('Effective')->date()->searchable(),
                    TextColumn::make('expiry_date')->label('Expiry')->date()->searchable(),
                    TextColumn::make('verification_status')->label('Verification')->badge()->color('success')->searchable(),
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
