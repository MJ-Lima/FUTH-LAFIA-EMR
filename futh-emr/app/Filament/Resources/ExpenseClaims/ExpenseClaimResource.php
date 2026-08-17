<?php

namespace App\Filament\Resources\ExpenseClaims;

use App\Filament\Resources\ExpenseClaims\Pages\CreateExpenseClaim;
use App\Filament\Resources\ExpenseClaims\Pages\EditExpenseClaim;
use App\Filament\Resources\ExpenseClaims\Pages\ListExpenseClaims;
use App\Filament\Resources\ExpenseClaims\Pages\ViewExpenseClaim;
use App\Filament\Resources\ExpenseClaims\Schemas\ExpenseClaimForm;
use App\Filament\Resources\ExpenseClaims\Schemas\ExpenseClaimInfolist;
use App\Filament\Resources\ExpenseClaims\Tables\ExpenseClaimsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\ExpenseClaim;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExpenseClaimResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = ExpenseClaim::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCurrencyDollar;

    protected static string|\UnitEnum|null $navigationGroup = 'Accounting';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'claim_number';

    public static function form(Schema $schema): Schema
    {
        return ExpenseClaimForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExpenseClaimInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpenseClaimsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListExpenseClaims::route('/'),
            'create' => CreateExpenseClaim::route('/create'),
            'view'   => ViewExpenseClaim::route('/{record}'),
            'edit'   => EditExpenseClaim::route('/{record}/edit'),
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
