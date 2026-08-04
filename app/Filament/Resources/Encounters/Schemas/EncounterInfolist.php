<?php

namespace App\Filament\Resources\Encounters\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EncounterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('hospital.name')
					->label('Hospital'),
                TextEntry::make('patient_id')
				->label('Patient Full name')
				->state(fn ($record) => "{$record->patient->lastname} {$record->patient->firstname} {$record->patient->middlename}"),
                TextEntry::make('clinic_id')
                    ->numeric(),
                TextEntry::make('user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('encounter_number'),
                TextEntry::make('visit_type')
                    ->badge(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('chief_complaint')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('appointment.appointment_date')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('appointment.appointment_time')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_by')
                    ->numeric(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
