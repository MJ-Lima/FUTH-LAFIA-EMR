<?php

namespace App\Filament\Resources\DutyRosters\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DutyRosterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('DutyRoster Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('hospital.name')->label('Hospital'),
                        TextEntry::make('start_date')->label('Start')->date(),
                        TextEntry::make('end_date')->label('End')->date(),
                        TextEntry::make('cycle')->label('Cycle'),
                        TextEntry::make('status')->label('Status'),
                    ])
                    ->columns(2),
            ]);
    }
}
