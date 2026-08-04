<?php


namespace App\Filament\Resources\RadiologyOrders\RelationManagers;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ResultRelationManager extends RelationManager
{
    protected static string $relationship = 'result';

    protected static ?string $title = 'Radiology Result';

    protected static ?string $modelLabel = 'Result';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Textarea::make('findings')
                    ->label('Findings')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                Textarea::make('impression')
                    ->label('Impression')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('recommendations')
                    ->label('Recommendations')
                    ->rows(3)
                    ->columnSpanFull(),
                DateTimePicker::make('reported_at')
                    ->label('Reported at'),
                Toggle::make('is_verified')
                    ->label('Verified'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('findings')
                    ->label('Findings')
                    ->limit(80)
                    ->wrap(),
                TextColumn::make('impression')
                    ->label('Impression')
                    ->limit(80)
                    ->wrap(),
                TextColumn::make('reported_at')
                    ->label('Reported at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean(),
                TextColumn::make('reporter.name')
                    ->label('Reported by')
                    ->toggleable(),
                TextColumn::make('verifier.name')
                    ->label('Verified by')
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}

