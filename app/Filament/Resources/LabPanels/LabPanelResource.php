<?php

namespace App\Filament\Resources\LabPanels;

use Filament\Schemas\Schema;

use App\Filament\Resources\LabPanels\Pages\CreateLabPanel;
use App\Filament\Resources\LabPanels\Pages\EditLabPanel;
use App\Filament\Resources\LabPanels\Pages\ListLabPanels;
use App\Filament\Resources\LabPanels\Pages\ViewLabPanel;
use App\Filament\Resources\LabPanels\Schemas\LabPanelForm;
use App\Filament\Resources\LabPanels\Schemas\LabPanelInfolist;
use App\Filament\Resources\LabPanels\Tables\LabPanelsTable;
use App\Models\LabPanel;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LabPanelResource extends Resource
{
    protected static ?string $model = LabPanel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    protected static \UnitEnum|string|null $navigationGroup = 'Laboratory';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LabPanelForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LabPanelInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LabPanelsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLabPanels::route('/'),
            'create' => CreateLabPanel::route('/create'),
            'view' => ViewLabPanel::route('/{record}'),
            'edit' => EditLabPanel::route('/{record}/edit'),
        ];
    }
}
