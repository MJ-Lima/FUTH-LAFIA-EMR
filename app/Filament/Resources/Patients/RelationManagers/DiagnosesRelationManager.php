<?php


namespace App\Filament\Resources\Patients\RelationManagers;

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

class DiagnosesRelationManager extends RelationManager
{
    protected static string $relationship = 'diagnoses';

    public function form(Schema $form): Schema
    {
        return $form->schema([
            TextInput::make('icd10_code')->label('ICD-10 Code')->required(),
            TextInput::make('description')->required(),
            Select::make('type')->options([
                'Principal' => 'Principal', 'Admitting' => 'Admitting',
                'Working' => 'Working', 'Discharge' => 'Discharge',
                'Secondary' => 'Secondary', 'Comorbidity' => 'Comorbidity',
            ])->default('Working'),
            Select::make('status')->options([
                'Active' => 'Active', 'Resolved' => 'Resolved',
                'Chronic' => 'Chronic', 'Recurrent' => 'Recurrent',
            ])->default('Active'),
            DatePicker::make('onset_date'),
            DatePicker::make('resolved_date'),
            Textarea::make('notes')->rows(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('icd10_code')->label('ICD-10')->searchable(),
                TextColumn::make('description')->limit(50),
                TextColumn::make('type')->badge(),
                TextColumn::make('status')->badge()
                    ->color(fn (string $s) => match ($s) {
                        'Active' => 'danger', 'Chronic' => 'warning',
                        'Recurrent' => 'warning', 'Resolved' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('onset_date')->date(),
            ])
            ->filters([])
            ->headerActions([CreateAction::make()])
            ->recordActions([ViewAction::make(), EditAction::make(), DeleteAction::make()]);
    }
}

