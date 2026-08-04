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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LabOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'labOrders';

    public function form(Schema $form): Schema
    {
        return $form->schema([
            Select::make('encounter_id')->relationship('encounter', 'encounter_number')->searchable(),
            Select::make('priority')->options([
                'Routine' => 'Routine', 'Urgent' => 'Urgent', 'STAT' => 'STAT', 'ASAP' => 'ASAP',
            ])->default('Routine'),
            Select::make('status')->options([
                'Pending' => 'Pending', 'Sample Collected' => 'Sample Collected',
                'In Progress' => 'In Progress', 'Completed' => 'Completed',
                'Verified' => 'Verified', 'Cancelled' => 'Cancelled', 'Rejected' => 'Rejected',
            ])->default('Pending'),
            Textarea::make('clinical_notes')->rows(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->searchable(),
                TextColumn::make('priority')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('ordered_at')->dateTime(),
                TextColumn::make('resulted_at')->dateTime(),
            ])
            ->defaultSort('ordered_at', 'desc')
            ->filters([])
            ->headerActions([CreateAction::make()])
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()]);
    }
}

