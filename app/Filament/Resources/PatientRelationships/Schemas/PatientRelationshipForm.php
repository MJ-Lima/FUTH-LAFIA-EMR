<?php

namespace App\Filament\Resources\PatientRelationships\Schemas;

use Filament\Forms\Components\DatePicker, Select, TextInput, Textarea, Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class PatientRelationshipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('PatientRelationship Details')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('patient_id')->label('Patient')->required()->relationship('patient', 'full_name')->searchable()->preload(),
                            Select::make('related_patient_id')->label('Related Patient')->relationship('related_patient', 'full_name')->searchable()->preload(),
                            Select::make('relationship_type_id')->label('Relationship Type')->required()->relationship('relationship_type', 'name')->searchable()->preload(),
                            TextInput::make('related_party_name')->label('Related Party Name (if not patient)'),
                            TextInput::make('related_party_phone')->label('Related Party Phone')->tel(),
                            TextInput::make('related_party_email')->label('Related Party Email')->email(),
                            Textarea::make('related_party_address')->label('Related Party Address'),
                            DatePicker::make('effective_date')->label('Effective Date'),
                            DatePicker::make('end_date')->label('End Date'),
                            Toggle::make('is_primary_contact')->label('Primary Contact'),
                            Toggle::make('is_emergency_contact')->label('Emergency Contact'),
                            Toggle::make('can_make_decisions')->label('Can Make Decisions'),
                            Textarea::make('notes')->label('Notes'),
                            Select::make('status')->label('Status')->required()->options(['Active' => 'Active', 'Inactive' => 'Inactive', 'Terminated' => 'Terminated'])->searchable(),
                        ]),
                    ]),
            ]);
    }
}
