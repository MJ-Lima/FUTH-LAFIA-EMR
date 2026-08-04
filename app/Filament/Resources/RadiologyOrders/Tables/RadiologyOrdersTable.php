<?php

namespace App\Filament\Resources\RadiologyOrders\Tables;

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

class RadiologyOrdersTable
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
                TextColumn::make('modality.name')
                    ->label('Modality')
                    ->badge()
                    ->sortable(),
                TextColumn::make('examination')
                    ->label('Examination')
                    ->searchable()
                    ->limit(60)
                    ->wrap(),
                TextColumn::make('body_part')
                    ->label('Body part')
                    ->toggleable(),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'STAT' => 'danger',
                        'Urgent' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Scheduled' => 'info',
                        'In Progress' => 'warning',
                        'Completed' => 'success',
                        'Verified' => 'success',
                        'Cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('ordered_at')
                    ->label('Ordered at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('performed_at')
                    ->label('Performed at')
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
                        'Scheduled' => 'Scheduled',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Verified' => 'Verified',
                        'Cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'Routine' => 'Routine',
                        'Urgent' => 'Urgent',
                        'STAT' => 'STAT',
                    ]),
                SelectFilter::make('modality_id')
                    ->label('Modality')
                    ->relationship('modality', 'name')
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
