<?php

namespace App\Filament\Resources\PreAuthorizations;

use App\Filament\Resources\PreAuthorizations\Pages\CreatePreAuthorization;
use App\Filament\Resources\PreAuthorizations\Pages\EditPreAuthorization;
use App\Filament\Resources\PreAuthorizations\Pages\ListPreAuthorizations;
use App\Filament\Resources\PreAuthorizations\Pages\ViewPreAuthorization;
use App\Filament\Resources\PreAuthorizations\Schemas\PreAuthorizationForm;
use App\Filament\Resources\PreAuthorizations\Schemas\PreAuthorizationInfolist;
use App\Filament\Resources\PreAuthorizations\Tables\PreAuthorizationsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\PreAuthorization;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PreAuthorizationResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = PreAuthorization::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Insurance';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'authorization_number';

    public static function form(Schema $schema): Schema
    {
        return PreAuthorizationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PreAuthorizationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreAuthorizationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPreAuthorizations::route('/'),
            'create' => CreatePreAuthorization::route('/create'),
            'view'   => ViewPreAuthorization::route('/{record}'),
            'edit'   => EditPreAuthorization::route('/{record}/edit'),
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
