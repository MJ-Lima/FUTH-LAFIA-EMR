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

class RadiologyOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'radiologyOrders';

    public function form(Schema $form): Schema
    {
        return $form->schema([
            Select::make('encounter_id')->relationship('encounter', 'encounter_number')->searchable(),
            Select::make('modality_id')->relationship('modality', 'name')->searchable()->preload(),
            TextInput::make('examination')->required(),
            TextInput::make('body_part'),
            Select::make('priority')->options([
                'Routine' => 'Routine', 'Urgent' => 'Urgent', 'STAT' => 'STAT',
            ])->default('Routine'),
            Select::make('status')->options([
                'Pending' => 'Pending', 'Scheduled' => 'Scheduled',
                'In Progress' => 'In Progress', 'Completed' => 'Completed',
                'Verified' => 'Verified', 'Cancelled' => 'Cancelled',
            ])->default('Pending'),
            Textarea::make('clinical_indication')->rows(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->searchable(),
                TextColumn::make('modality.name')->badge(),
                TextColumn::make('examination')->limit(40),
                TextColumn::make('priority')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('ordered_at')->dateTime(),
            ])
            ->defaultSort('ordered_at', 'desc')
            ->filters([])
            ->headerActions([CreateAction::make()])
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()]);
    }
}

