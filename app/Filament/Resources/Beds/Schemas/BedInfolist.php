<?php

namespace App\Filament\Resources\Beds\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BedInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Bed Information')
                    ->schema([
                        TextEntry::make('bed_number')->label('Bed #'),
                        TextEntry::make('ward.name')->label('Ward'),
                        TextEntry::make('type')->label('Type'),
                        TextEntry::make('class')->label('Class'),
                        TextEntry::make('daily_rate')->label('Rate'),
                        TextEntry::make('status')->label('Status'),
                        TextEntry::make('currentAdmission.admission_number')->label('Current Admission'),
                    ])
                    ->columns(2),
            ]);
    }
}
