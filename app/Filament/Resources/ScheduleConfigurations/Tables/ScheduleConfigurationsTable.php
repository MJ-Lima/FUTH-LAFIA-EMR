<?php

namespace App\Filament\Resources\ScheduleConfigurations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use App\Models\ScheduleConfiguration;

class ScheduleConfigurationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('clinic.name'),
				TextColumn::make('day_of_week')
					->formatStateUsing(fn ($state) => ScheduleConfiguration::daysOfWeek()[$state]),
				TextColumn::make('start_time')->time(),
				TextColumn::make('end_time')->time(),
				TextColumn::make('slot_duration_minutes')->suffix(' min'),
				IconColumn::make('is_active')->boolean(),
			])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
