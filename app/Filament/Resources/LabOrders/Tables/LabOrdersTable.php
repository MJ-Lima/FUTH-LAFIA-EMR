<?php

namespace App\Filament\Resources\LabOrders\Tables;

use Filament\Schemas\Schema;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LabOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.full_name')
                    ->label('Patient')
                    ->searchable(['firstname', 'lastname'])
                    ->sortable(),
                TextColumn::make('patient.patientcode')
                    ->label('Patient code')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('encounter.encounter_number')
                    ->label('Encounter')
                    ->toggleable(),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'STAT' => 'danger',
                        'ASAP' => 'danger',
                        'Urgent' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Sample Collected' => 'info',
                        'In Progress' => 'warning',
                        'Completed' => 'success',
                        'Verified' => 'success',
                        'Cancelled' => 'danger',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('ordered_at')
                    ->label('Ordered at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('collected_at')
                    ->label('Collected at')
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('resulted_at')
                    ->label('Resulted at')
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('requester.name')
                    ->label('Requester')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Sample Collected' => 'Sample Collected',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Verified' => 'Verified',
                        'Cancelled' => 'Cancelled',
                        'Rejected' => 'Rejected',
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'Routine' => 'Routine',
                        'Urgent' => 'Urgent',
                        'STAT' => 'STAT',
                        'ASAP' => 'ASAP',
                    ]),
                SelectFilter::make('patient_id')
                    ->label('Patient')
                    ->relationship('patient', 'patientcode')
                    ->searchable()
                    ->preload(),
                Filter::make('ordered_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('Ordered from'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('Ordered until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn ($q, $d) => $q->whereDate('ordered_at', '>=', $d))
                            ->when($data['until'] ?? null, fn ($q, $d) => $q->whereDate('ordered_at', '<=', $d));
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
