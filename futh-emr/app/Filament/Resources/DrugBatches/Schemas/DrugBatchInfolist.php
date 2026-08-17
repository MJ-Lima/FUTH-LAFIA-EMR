<?php

namespace App\Filament\Resources\DrugBatches\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DrugBatchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('DrugBatch Information')
                    ->schema([
                        TextEntry::make('batch_number')->label('Batch #'),
                        TextEntry::make('drug.name')->label('Drug'),
                        TextEntry::make('expiry_date')->label('Expiry')->date(),
                        TextEntry::make('quantity_received')->label('Received'),
                        TextEntry::make('quantity_remaining')->label('Remaining'),
                        TextEntry::make('is_quarantined')->label('Quarantined'),
                    ])
                    ->columns(2),
            ]);
    }
}
