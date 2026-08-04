<?php

namespace App\Filament\Resources\Encounters\RelationManagers;

use Filament\Schemas\Schema;


use Filament\Forms\Components\DatePicker;
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

class VitalsRelationManager extends RelationManager
{
    protected static string $relationship = 'vitals';

    public function form(Schema $form): Schema
    {
        return $form->schema([
            DateTimePicker::make('recorded_at')->required()->default(now()),
            Select::make('encounter_id')->relationship('encounter', 'encounter_number')->searchable(),
            TextInput::make('temperature_c')->numeric()->label('Temperature (°C)'),
            TextInput::make('systolic_bp')->numeric()->label('Systolic BP'),
            TextInput::make('diastolic_bp')->numeric()->label('Diastolic BP'),
            TextInput::make('heart_rate')->numeric()->label('Heart rate (bpm)'),
            TextInput::make('respiratory_rate')->numeric()->label('RR (/min)'),
            TextInput::make('spo2')->numeric()->label('SpO2 (%)'),
            TextInput::make('weight_kg')->numeric()->label('Weight (kg)'),
            TextInput::make('height_cm')->numeric()->label('Height (cm)'),
            TextInput::make('blood_glucose_mmol_l')->numeric()->label('Glucose (mmol/L)'),
            Textarea::make('notes')->rows(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('recorded_at')->dateTime()->sortable(),
                TextColumn::make('temperature_c')->label('Temp'),
                TextColumn::make('bp')->label('BP'),
                TextColumn::make('heart_rate')->label('HR'),
                TextColumn::make('respiratory_rate')->label('RR'),
                TextColumn::make('spo2')->label('SpO2'),
                TextColumn::make('weight_kg')->label('Wt'),
                TextColumn::make('bmi')->label('BMI'),
                TextColumn::make('blood_glucose_mmol_l')->label('Gluc'),
            ])
            ->defaultSort('recorded_at', 'desc')
            ->filters([])
            ->headerActions([CreateAction::make()])
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()]);
    }
}

