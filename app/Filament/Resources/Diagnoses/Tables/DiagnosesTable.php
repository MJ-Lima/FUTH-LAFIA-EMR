<?php

namespace App\Filament\Resources\Diagnoses\Tables;
use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DiagnosesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.full_name')->label('Patient')->searchable()->sortable(),
                TextColumn::make('patient.patientcode')->label('Code')->toggleable(),
                TextColumn::make('icd10_code')->label('ICD-10')->searchable()->sortable(),
                TextColumn::make('description')->limit(60)->searchable(),
                TextColumn::make('type')->badge(),
                TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'danger',
                        'Chronic' => 'warning',
                        'Recurrent' => 'warning',
                        'Resolved' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('onset_date')->date(),
                TextColumn::make('resolved_date')->date()->toggleable(),
                TextColumn::make('recorder.name')->label('By')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type'),
                SelectFilter::make('status'),
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
