<?php


namespace App\Filament\Resources\Patients\RelationManagers;

use Filament\Schemas\Schema;

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

class PrescriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'prescriptions';

    public function form(Schema $form): Schema
    {
        return $form->schema([
            Select::make('encounter_id')->relationship('encounter', 'encounter_number')->searchable(),
            Select::make('dispensing_point_id')->relationship('dispensingPoint', 'name')->searchable(),
            Select::make('priority')->options([
                'Routine' => 'Routine', 'Urgent' => 'Urgent', 'STAT' => 'STAT',
            ])->default('Routine'),
            Select::make('status')->options([
                'Pending' => 'Pending', 'Partially Dispensed' => 'Partially Dispensed',
                'Dispensed' => 'Dispensed', 'Cancelled' => 'Cancelled', 'Rejected' => 'Rejected',
            ])->default('Pending'),
            TextInput::make('prescription_number')->disabled(),
            Textarea::make('notes')->rows(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prescription_number')->searchable(),
                TextColumn::make('priority')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('prescribed_at')->dateTime(),
                TextColumn::make('dispensed_at')->dateTime(),
            ])
            ->defaultSort('prescribed_at', 'desc')
            ->filters([])
            ->headerActions([CreateAction::make()])
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()]);
    }
}

