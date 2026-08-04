<?php

namespace App\Filament\Resources\LabTests\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class LabTestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Test Information')
                    ->schema([
                        TextEntry::make('name')->label('Test name'),
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('loinc_code')->label('LOINC code'),
                        TextEntry::make('panel.name')->label('Panel'),
                        TextEntry::make('specimen_type')->label('Specimen type'),
                        TextEntry::make('container')->label('Container'),
                        TextEntry::make('unit')->label('Reporting unit'),
                    ])->columns(3),

                Section::make('Reference Range')
                    ->schema([
                        TextEntry::make('reference_range_low')->label('Lower bound'),
                        TextEntry::make('reference_range_high')->label('Upper bound'),
                        TextEntry::make('reference_notes')->label('Reference notes')->columnSpanFull(),
                    ])->columns(2),

                Section::make('Pricing & Turnaround')
                    ->schema([
                        TextEntry::make('price')->label('Price')->money('NGN'),
                        TextEntry::make('turnaround_hours')->label('Turnaround')->suffix(' hrs'),
                        TextEntry::make('status')
                            ->label('Active')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                            ->color(fn ($state) => $state ? 'success' : 'gray'),
                    ])->columns(3),

                Section::make('Description')
                    ->schema([
                        TextEntry::make('description')->columnSpanFull(),
                    ])->columns(1),
            ]);
    }
}
