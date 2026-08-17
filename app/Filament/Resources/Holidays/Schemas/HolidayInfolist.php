<?php

namespace App\Filament\Resources\Holidays\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HolidayInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Holiday Information')
                    ->schema([
                        TextEntry::make('name')->label('Holiday Name'),
                        TextEntry::make('holiday_date')->label('Start')->date(),
                        TextEntry::make('end_date')->label('End')->date(),
                        TextEntry::make('type')->label('Type'),
                        TextEntry::make('is_working_day')->label('Working Day'),
                        TextEntry::make('affects_clinics')->label('Affects Clinics'),
                    ])
                    ->columns(2),
            ]);
    }
}
