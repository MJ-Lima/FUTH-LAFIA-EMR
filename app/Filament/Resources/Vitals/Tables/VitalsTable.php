<?php

namespace App\Filament\Resources\Vitals\Tables;

use Filament\Schemas\Schema;


use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VitalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(['firstname', 'lastname'])
                    ->sortable(),
                TextColumn::make('patient.patientcode')
                    ->label('Patient code')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('recorded_at')
                    ->label('Recorded at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('temperature_c')
                    ->label('Temp')
                    ->suffix(' °C')
                    ->toggleable(),
                TextColumn::make('bp')
                    ->label('BP')
                    ->toggleable(),
                TextColumn::make('heart_rate')
                    ->label('HR')
                    ->suffix(' bpm')
                    ->toggleable(),
                TextColumn::make('respiratory_rate')
                    ->label('RR')
                    ->suffix(' /min')
                    ->toggleable(),
                TextColumn::make('spo2')
                    ->label('SpO₂')
                    ->suffix(' %')
                    ->toggleable(),
                TextColumn::make('pain_score')
                    ->label('Pain')
                    ->toggleable(),
                TextColumn::make('weight_kg')
                    ->label('Weight')
                    ->suffix(' kg')
                    ->toggleable(),
                TextColumn::make('height_cm')
                    ->label('Height')
                    ->suffix(' cm')
                    ->toggleable(),
                TextColumn::make('bmi')
                    ->label('BMI')
                    ->toggleable(),
                TextColumn::make('blood_glucose_mmol_l')
                    ->label('Glucose')
                    ->suffix(' mmol/L')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('patient_id')
                    ->label('Patient')
                    ->relationship('patient', 'patientcode')
                    ->searchable()
                    ->preload(),
                Filter::make('recorded_at')
                    ->form([
                        DatePicker::make('from')->label('Recorded from'),
                        DatePicker::make('until')->label('Recorded until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $d) => $q->whereDate('recorded_at', '>=', $d))
                            ->when($data['until'], fn ($q, $d) => $q->whereDate('recorded_at', '<=', $d));
                    }),
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
