<?php

namespace App\Filament\Resources\LabTests;

use App\Filament\Resources\LabTests\Pages\CreateLabTest;
use App\Filament\Resources\LabTests\Pages\EditLabTest;
use App\Filament\Resources\LabTests\Pages\ListLabTests;
use App\Filament\Resources\LabTests\Pages\ViewLabTest;
use App\Filament\Resources\LabTests\Schemas\LabTestForm;
use App\Filament\Resources\LabTests\Schemas\LabTestInfolist;
use App\Filament\Resources\LabTests\Tables\LabTestsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\LabTest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LabTestResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = LabTest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|\UnitEnum|null $navigationGroup = 'Laboratory';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return LabTestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LabTestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LabTestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListLabTests::route('/'),
            'create' => CreateLabTest::route('/create'),
            'view'   => ViewLabTest::route('/{record}'),
            'edit'   => EditLabTest::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getEloquentQuery()->count());
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
