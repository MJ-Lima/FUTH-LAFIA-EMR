<?php

namespace App\Filament\Resources\DispensingLogs;

use Filament\Schemas\Schema;

use App\Filament\Resources\DispensingLogs\Pages\CreateDispensingLog;
use App\Filament\Resources\DispensingLogs\Pages\EditDispensingLog;
use App\Filament\Resources\DispensingLogs\Pages\ListDispensingLogs;
use App\Filament\Resources\DispensingLogs\Pages\ViewDispensingLog;
use App\Filament\Resources\DispensingLogs\Schemas\DispensingLogForm;
use App\Filament\Resources\DispensingLogs\Schemas\DispensingLogInfolist;
use App\Filament\Resources\DispensingLogs\Tables\DispensingLogsTable;
use App\Models\DispensingLog;
use BackedEnum;
use Filament\Resources\Resource;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DispensingLogResource extends Resource
{
    protected static ?string $model = DispensingLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static \UnitEnum|string|null $navigationGroup = 'Pharmacy';

    protected static ?string $recordTitleAttribute = 'reference_number';

    public static function form(Schema $schema): Schema
    {
        return DispensingLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DispensingLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DispensingLogsTable::configure($table);
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
            'index' => ListDispensingLogs::route('/'),
            'create' => CreateDispensingLog::route('/create'),
            'view' => ViewDispensingLog::route('/{record}'),
            'edit' => EditDispensingLog::route('/{record}/edit'),
        ];
    }
}
