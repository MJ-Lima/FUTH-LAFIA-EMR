<?php

namespace App\Filament\Resources\Drugs\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;


class DrugInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Drug Information')
                    ->schema([
                        TextEntry::make('name')->label('Brand name'),
                        TextEntry::make('generic_name')->label('Generic name'),
                        TextEntry::make('code')->label('Code'),
                        TextEntry::make('atc_code')->label('ATC code'),
                        TextEntry::make('category.name')->label('Category'),
                    ])->columns(2),

                Section::make('Formulation')
                    ->schema([
                        TextEntry::make('dosage_form')->label('Dosage form'),
                        TextEntry::make('strength')->label('Strength'),
                        TextEntry::make('unit_of_measure')->label('Unit of measure'),
                        TextEntry::make('manufacturer')->label('Manufacturer'),
                        TextEntry::make('supplier')->label('Supplier'),
                    ])->columns(2),

                Section::make('Pricing & Stock')
                    ->schema([
                        TextEntry::make('cost_price')->label('Cost price')->money('NGN'),
                        TextEntry::make('selling_price')->label('Selling price')->money('NGN'),
                        TextEntry::make('reorder_level')->label('Reorder level'),
                        TextEntry::make('reorder_quantity')->label('Reorder quantity'),
                        TextEntry::make('stock')
                            ->label('Current stock')
                            ->state(fn ($record) => $record->currentStock())
                            ->suffix(' units'),
                        TextEntry::make('is_below_reorder')
                            ->label('Low stock?')
                            ->state(fn ($record) => $record->isBelowReorder() ? 'Yes' : 'No')
                            ->badge()
                            ->color(fn ($state) => $state === 'Yes' ? 'danger' : 'success'),
                    ])->columns(2),

                Section::make('Safety Flags')
                    ->schema([
                        TextEntry::make('is_controlled')
                            ->label('Controlled substance')
                            ->badge()
                            ->state(fn ($record) => $record->is_controlled ? 'Yes' : 'No')
                            ->color(fn ($state) => $state === 'Yes' ? 'danger' : 'gray'),
                        TextEntry::make('is_antenatal_safe')
                            ->label('Safe in pregnancy')
                            ->badge()
                            ->state(fn ($record) => $record->is_antenatal_safe ? 'Yes' : 'No')
                            ->color(fn ($state) => $state === 'Yes' ? 'success' : 'warning'),
                        TextEntry::make('is_pediatric_safe')
                            ->label('Pediatric safe')
                            ->badge()
                            ->state(fn ($record) => $record->is_pediatric_safe ? 'Yes' : 'No')
                            ->color(fn ($state) => $state === 'Yes' ? 'success' : 'warning'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->state(fn ($record) => $record->status ? 'Active' : 'Inactive')
                            ->color(fn ($state) => $state === 'Active' ? 'success' : 'gray'),
                    ])->columns(2),
            ]);
    }
}
