<?php

namespace App\Filament\Resources\InsuranceClaims\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class InsuranceClaimsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('claim_number')->label('Claim #')->searchable(),
                    TextColumn::make('patient.full_name')->label('Patient')->sortable(),
                    TextColumn::make('provider.name')->label('Provider')->sortable(),
                    TextColumn::make('claim_type')->label('Type')->badge()->color('success')->searchable(),
                    TextColumn::make('service_date_start')->label('Service From')->date()->searchable(),
                    TextColumn::make('total_claimed')->label('Claimed')->searchable(),
                    TextColumn::make('total_approved')->label('Approved')->searchable(),
                    TextColumn::make('total_paid')->label('Paid')->searchable(),
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
