<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class AppointmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Appointment')
                    ->schema([
                        TextEntry::make('appointment_number')->label('Appointment #'),
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('patient.patientcode')->label('Patient code'),
                        TextEntry::make('clinic.name')->label('Clinic'),
                        TextEntry::make('provider.name')->label('Provider'),
                        TextEntry::make('appointment_date')->date(),
                        TextEntry::make('appointment_time')->time(),
                        TextEntry::make('estimated_duration')->suffix(' min'),
                        TextEntry::make('visit_type')->badge(),
                        TextEntry::make('priority')->badge(),
                        TextEntry::make('status')->badge(),
                        TextEntry::make('reason_for_visit')->columnSpanFull(),
                        TextEntry::make('notes')->columnSpanFull(),
                    ])->columns(3),
            ]);
    }
}
