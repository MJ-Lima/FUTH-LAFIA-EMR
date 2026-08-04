<?php


namespace App\Filament\Resources\Patients\RelationManagers;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';

    public function form(Schema $form): Schema
    {
        return $form->schema([
            Select::make('clinic_id')->relationship('clinic', 'name')->searchable()->preload(),
            Select::make('provider_id')->relationship('provider', 'name')->searchable(),
            Select::make('visit_type')->options([
                'New' => 'New', 'Follow-up' => 'Follow-up', 'Review' => 'Review', 'Telemedicine' => 'Telemedicine',
            ])->required(),
            Select::make('status')->options([
                'Scheduled' => 'Scheduled', 'Confirmed' => 'Confirmed', 'Checked In' => 'Checked In',
                'Completed' => 'Completed', 'Cancelled' => 'Cancelled', 'No Show' => 'No Show',
            ])->default('Scheduled'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('appointment_number')->searchable(),
                TextColumn::make('clinic.name'),
                TextColumn::make('provider.name'),
                TextColumn::make('appointment_date')->date(),
                TextColumn::make('appointment_time')->time(),
                TextColumn::make('visit_type')->badge(),
                TextColumn::make('status')->badge(),
            ])
            ->defaultSort('appointment_date', 'desc')
            ->filters([])
            ->headerActions([CreateAction::make()])
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()]);
    }
}

