<?php


namespace App\Filament\Resources\Patients\RelationManagers;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EncountersRelationManager extends RelationManager
{
    protected static string $relationship = 'encounters';

    public function form(Schema $form): Schema
    {
        return $form->schema([
            TextInput::make('encounter_number')->disabled(),
            Select::make('clinic_id')->relationship('clinic', 'name')->searchable()->preload(),
            Select::make('visit_type')->options([
                'Outpatient' => 'Outpatient', 'Emergency' => 'Emergency',
                'Inpatient' => 'Inpatient', 'Telemedicine' => 'Telemedicine', 'Follow-up' => 'Follow-up',
            ])->required(),
            Select::make('status')->options([
                'Waiting' => 'Waiting', 'In Progress' => 'In Progress',
                'Completed' => 'Completed', 'Cancelled' => 'Cancelled',
            ])->default('Waiting')->required(),
            DateTimePicker::make('encounter_date')->required(),
            Textarea::make('chief_complaint')->rows(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('encounter_number')->searchable(),
                TextColumn::make('clinic.name'),
                TextColumn::make('visit_type')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('encounter_date')->dateTime(),
            ])
            ->filters([])
            ->headerActions([CreateAction::make()])
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()]);
    }
}

