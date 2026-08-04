<?php

namespace App\Filament\Resources\ClinicalNotes\Tables;

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

class ClinicalNotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('note_number')->label('Note #')->searchable()->sortable(),
                TextColumn::make('patient.full_name')->label('Patient')->searchable()->sortable(),
                TextColumn::make('encounter.encounter_number')->label('Encounter')->toggleable(),
                TextColumn::make('note_type')->badge(),
                TextColumn::make('title')->limit(40)->toggleable(),
                TextColumn::make('author.name')->label('Author')->sortable(),
                IconColumn::make('is_signed')
                    ->label('Signed')
                    ->boolean(),
                TextColumn::make('signed_at')->dateTime()->toggleable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('note_type')
                    ->options([
                        'Progress' => 'Progress',
                        'Admission' => 'Admission',
                        'Discharge' => 'Discharge',
                        'Nursing' => 'Nursing',
                        'Procedure' => 'Procedure',
                        'Consultation' => 'Consultation',
                        'Referral' => 'Referral',
                        'Death' => 'Death',
                        'Other' => 'Other',
                    ]),
                SelectFilter::make('is_signed')
                    ->label('Signed')
                    ->options([0 => 'Unsigned', 1 => 'Signed']),
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
