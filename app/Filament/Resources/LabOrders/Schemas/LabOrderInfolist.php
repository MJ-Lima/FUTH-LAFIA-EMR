<?php

namespace App\Filament\Resources\LabOrders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LabOrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('LabOrder Information')
                    ->schema([
                        TextEntry::make('order_number')->label('Order #'),
                        TextEntry::make('patient.full_name')->label('Patient'),
                        TextEntry::make('requester.name')->label('Requester'),
                        TextEntry::make('ordered_at')->label('Ordered')->dateTime(),
                        TextEntry::make('priority')->label('Priority'),
                        TextEntry::make('status')->label('Status'),
                    ])
                    ->columns(2),
            ]);
    }
}
