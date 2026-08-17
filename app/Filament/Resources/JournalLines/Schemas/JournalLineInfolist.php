<?php

namespace App\Filament\Resources\JournalLines\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JournalLineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('JournalLine Information')
                    ->schema([
                        TextEntry::make('journalEntry.entry_number')->label('Journal Entry'),
                        TextEntry::make('chartOfAccount.account_code')->label('Account'),
                        TextEntry::make('chartOfAccount.name')->label('Account Name'),
                        TextEntry::make('description')->label('Description'),
                        TextEntry::make('debit')->label('Debit'),
                        TextEntry::make('credit')->label('Credit'),
                    ])
                    ->columns(2),
            ]);
    }
}
