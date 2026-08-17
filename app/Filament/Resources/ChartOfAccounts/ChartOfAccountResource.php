<?php

namespace App\Filament\Resources\ChartOfAccounts;

use App\Filament\Resources\ChartOfAccounts\Pages\CreateChartOfAccount;
use App\Filament\Resources\ChartOfAccounts\Pages\EditChartOfAccount;
use App\Filament\Resources\ChartOfAccounts\Pages\ListChartOfAccounts;
use App\Filament\Resources\ChartOfAccounts\Pages\ViewChartOfAccount;
use App\Filament\Resources\ChartOfAccounts\Schemas\ChartOfAccountForm;
use App\Filament\Resources\ChartOfAccounts\Schemas\ChartOfAccountInfolist;
use App\Filament\Resources\ChartOfAccounts\Tables\ChartOfAccountsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\ChartOfAccount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ChartOfAccountResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = ChartOfAccount::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|\UnitEnum|null $navigationGroup = 'Accounting';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'account_code';

    public static function form(Schema $schema): Schema
    {
        return ChartOfAccountForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ChartOfAccountInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChartOfAccountsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListChartOfAccounts::route('/'),
            'create' => CreateChartOfAccount::route('/create'),
            'view'   => ViewChartOfAccount::route('/{record}'),
            'edit'   => EditChartOfAccount::route('/{record}/edit'),
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
