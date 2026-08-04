<?php

namespace App\Filament\Resources\DrugInteractions\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;


class DrugInteractionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Drug Pair')
                    ->schema([
                        Select::make('drug_a_id')
                            ->label('Drug A')
                            ->relationship('drugA', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('drug_b_id')
                            ->label('Drug B')
                            ->relationship('drugB', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])->columns(2),

                Section::make('Interaction')
                    ->schema([
                        Select::make('severity')
                            ->label('Severity')
                            ->options([
                                'Minor' => 'Minor',
                                'Moderate' => 'Moderate',
                                'Major' => 'Major',
                                'Contraindicated' => 'Contraindicated',
                            ])
                            ->default('Moderate')
                            ->required(),
                        Select::make('effect')
                            ->label('Effect')
                            ->options([
                                'Additive Effect' => 'Additive Effect',
                                'Synergistic Effect' => 'Synergistic Effect',
                                'Antagonistic Effect' => 'Antagonistic Effect',
                                'Increased Effect' => 'Increased Effect',
                                'Decreased Effect' => 'Decreased Effect',
                                'Increased Toxicity' => 'Increased Toxicity',
                                'Decreased Toxicity' => 'Decreased Toxicity',
                                'Altered Pharmacokinetics' => 'Altered Pharmacokinetics',
                            ]),
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('clinical_action')
                            ->label('Clinical action')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Source')
                    ->schema([
                        TextInput::make('source')
                            ->label('Source')
                            ->placeholder('e.g. Stockley 2024')
                            ->maxLength(150),
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
