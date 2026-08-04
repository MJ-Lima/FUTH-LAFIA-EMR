<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class SupplierInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Supplier Information')
                    ->schema([
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('contact_person')->label('Contact person'),
                        TextEntry::make('phone')->label('Phone'),
                        TextEntry::make('email')->label('Email'),
                    ])->columns(2),

                Section::make('Address & Compliance')
                    ->schema([
                        TextEntry::make('address')->label('Address')->columnSpanFull(),
                        TextEntry::make('tax_id')->label('Tax ID'),
                        TextEntry::make('registration_number')->label('Registration number'),
                    ])->columns(2),

                Section::make('Status')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->state(fn ($record) => $record->status ? 'Active' : 'Inactive')
                            ->color(fn ($state) => $state === 'Active' ? 'success' : 'gray'),
                    ])->columns(1),
            ]);
    }
}
