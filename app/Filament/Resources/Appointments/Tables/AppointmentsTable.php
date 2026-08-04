<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('appointment_number')
                    ->label('Appt #')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(['firstname', 'lastname'])
                    ->sortable(),
                TextColumn::make('patient.patientcode')
                    ->label('Patient Code')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('clinic.name')
                    ->label('Clinic')
                    ->sortable(),
                TextColumn::make('provider.name')
                    ->label('Provider')
                    ->sortable(),
                TextColumn::make('appointment_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('appointment_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('visit_type')
                    ->badge(),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Emergency' => 'danger',
                        'Urgent' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Scheduled' => 'gray',
                        'Confirmed' => 'info',
                        'Checked In' => 'warning',
                        'Completed' => 'success',
                        'Cancelled' => 'danger',
                        'No Show' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Scheduled' => 'Scheduled',
                        'Confirmed' => 'Confirmed',
                        'Checked In' => 'Checked In',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                        'No Show' => 'No Show',
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'Routine' => 'Routine',
                        'Urgent' => 'Urgent',
                        'Emergency' => 'Emergency',
                    ]),
                SelectFilter::make('visit_type')
                    ->options([
                        'New' => 'New',
                        'Follow-up' => 'Follow-up',
                        'Review' => 'Review',
                        'Telemedicine' => 'Telemedicine',
                    ]),
                Filter::make('appointment_date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('From'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $d) => $q->whereDate('appointment_date', '>=', $d))
                            ->when($data['until'], fn ($q, $d) => $q->whereDate('appointment_date', '<=', $d));
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
