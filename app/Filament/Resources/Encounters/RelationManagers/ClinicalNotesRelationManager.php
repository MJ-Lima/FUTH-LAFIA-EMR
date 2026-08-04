<?php

namespace App\Filament\Resources\Encounters\RelationManagers;
use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClinicalNotesRelationManager extends RelationManager
{
    protected static string $relationship = 'clinicalNotes';

    public function form(Schema $form): Schema
    {
        return $form->schema([
            Select::make('encounter_id')->relationship('encounter', 'encounter_number')->searchable(),
            Select::make('note_type')->options([
                'Progress' => 'Progress', 'Admission' => 'Admission', 'Discharge' => 'Discharge',
                'Nursing' => 'Nursing', 'Procedure' => 'Procedure', 'Consultation' => 'Consultation',
                'Referral' => 'Referral', 'Death' => 'Death', 'Other' => 'Other',
            ])->required()->default('Progress'),
            TextInput::make('title')->maxLength(255),
            Textarea::make('subjective')->label('S — Subjective')->rows(2),
            Textarea::make('objective')->label('O — Objective')->rows(2),
            Textarea::make('assessment')->label('A — Assessment')->rows(2),
            Textarea::make('plan')->label('P — Plan')->rows(2),
            Textarea::make('narrative')->rows(3),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('note_number')->searchable(),
                TextColumn::make('note_type')->badge(),
                TextColumn::make('title')->limit(40),
                TextColumn::make('author.name')->label('Author'),
                IconColumn::make('is_signed')->boolean(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([])
            ->headerActions([CreateAction::make()])
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()]);
    }
}

