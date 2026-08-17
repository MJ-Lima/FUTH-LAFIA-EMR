<?php

namespace App\Filament\Resources\ReportTemplates\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReportTemplateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ReportTemplate Information')
                    ->schema([
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('name')->label('Template'),
                        TextEntry::make('category')->label('Category'),
                        TextEntry::make('frequency')->label('Frequency'),
                        TextEntry::make('is_scheduled')->label('Scheduled'),
                        TextEntry::make('is_active')->label('Active'),
                    ])
                    ->columns(2),
            ]);
    }
}
