<?php

namespace App\Filament\Resources\BloodRequests;

use App\Filament\Resources\BloodRequests\Pages\CreateBloodRequest;
use App\Filament\Resources\BloodRequests\Pages\EditBloodRequest;
use App\Filament\Resources\BloodRequests\Pages\ListBloodRequests;
use App\Filament\Resources\BloodRequests\Pages\ViewBloodRequest;
use App\Filament\Resources\BloodRequests\Schemas\BloodRequestForm;
use App\Filament\Resources\BloodRequests\Schemas\BloodRequestInfolist;
use App\Filament\Resources\BloodRequests\Tables\BloodRequestsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\BloodRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BloodRequestResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = BloodRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Blood Bank';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'request_number';

    public static function form(Schema $schema): Schema
    {
        return BloodRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BloodRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BloodRequestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBloodRequests::route('/'),
            'create' => CreateBloodRequest::route('/create'),
            'view'   => ViewBloodRequest::route('/{record}'),
            'edit'   => EditBloodRequest::route('/{record}/edit'),
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
