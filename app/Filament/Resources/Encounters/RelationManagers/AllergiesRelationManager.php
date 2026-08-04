<?php

namespace App\Filament\Resources\Encounters\RelationManagers;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class AllergiesRelationManager extends RelationManager
{
    protected static string $relationship = 'allergies';

    public function form(Schema $form): Schema
    {
        return $form->schema([
            TextInput::make('substance')->label('Allergen')->required(),
            Select::make('category')->options([
                'Medication' => 'Medication', 'Food' => 'Food',
                'Environment' => 'Environment', 'Biologic' => 'Biologic', 'Other' => 'Other',
            ])->required()->default('Medication'),
            Select::make('severity')->options([
                'Mild' => 'Mild', 'Moderate' => 'Moderate', 'Severe' => 'Severe', 'Fatal' => 'Fatal',
            ])->required()->default('Mild'),
            Select::make('criticality')->options([
                'Low' => 'Low', 'High' => 'High', 'Unable to assess' => 'Unable to assess',
            ])->default('Low'),
            Select::make('reaction')->options([
                'Rash' => 'Rash', 'Urticaria' => 'Urticaria', 'Anaphylaxis' => 'Anaphylaxis',
                'Angioedema' => 'Angioedema', 'Bronchospasm' => 'Bronchospasm',
                'GI upset' => 'GI upset', 'Hepatotoxicity' => 'Hepatotoxicity',
                'Stevens-Johnson' => 'Stevens-Johnson', 'Other' => 'Other',
            ])->default('Rash'),
            Textarea::make('reaction_description')->rows(2),
            DatePicker::make('onset_date'),
            Select::make('status')->options([
                'Active' => 'Active', 'Resolved' => 'Resolved', 'Inactive' => 'Inactive',
            ])->default('Active'),
            Textarea::make('notes')->rows(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('substance')->searchable(),
                TextColumn::make('category')->badge(),
                TextColumn::make('severity')->badge()
                    ->color(fn (string $s) => match ($s) {
                        'Fatal' => 'danger', 'Severe' => 'danger',
                        'Moderate' => 'warning', 'Mild' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('reaction'),
                TextColumn::make('onset_date')->date(),
                TextColumn::make('status')->badge(),
            ])
            ->filters([])
            ->headerActions([CreateAction::make()])
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()]);
    }
}

