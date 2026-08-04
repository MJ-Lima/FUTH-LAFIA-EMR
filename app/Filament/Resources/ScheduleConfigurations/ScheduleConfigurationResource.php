<?php

namespace App\Filament\Resources\ScheduleConfigurations;

use App\Filament\Resources\ScheduleConfigurations\Pages\CreateScheduleConfiguration;
use App\Filament\Resources\ScheduleConfigurations\Pages\EditScheduleConfiguration;
use App\Filament\Resources\ScheduleConfigurations\Pages\ListScheduleConfigurations;
use App\Filament\Resources\ScheduleConfigurations\Pages\ViewScheduleConfiguration;
use App\Filament\Resources\ScheduleConfigurations\Schemas\ScheduleConfigurationForm;
use App\Filament\Resources\ScheduleConfigurations\Schemas\ScheduleConfigurationInfolist;
use App\Filament\Resources\ScheduleConfigurations\Tables\ScheduleConfigurationsTable;
use App\Models\ScheduleConfiguration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ScheduleConfigurationResource extends Resource
{
    protected static ?string $model = ScheduleConfiguration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ScheduleConfigurationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ScheduleConfigurationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScheduleConfigurationsTable::configure($table);
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
            'index' => ListScheduleConfigurations::route('/'),
            'create' => CreateScheduleConfiguration::route('/create'),
            'view' => ViewScheduleConfiguration::route('/{record}'),
            'edit' => EditScheduleConfiguration::route('/{record}/edit'),
        ];
    }
}
