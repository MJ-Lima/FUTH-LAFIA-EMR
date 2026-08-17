<?php

namespace App\Filament\Resources\PettyCashTransactions;

use App\Filament\Resources\PettyCashTransactions\Pages\CreatePettyCashTransaction;
use App\Filament\Resources\PettyCashTransactions\Pages\EditPettyCashTransaction;
use App\Filament\Resources\PettyCashTransactions\Pages\ListPettyCashTransactions;
use App\Filament\Resources\PettyCashTransactions\Pages\ViewPettyCashTransaction;
use App\Filament\Resources\PettyCashTransactions\Schemas\PettyCashTransactionForm;
use App\Filament\Resources\PettyCashTransactions\Schemas\PettyCashTransactionInfolist;
use App\Filament\Resources\PettyCashTransactions\Tables\PettyCashTransactionsTable;
use App\Filament\Traits\HasUnitScoping;
use App\Models\PettyCashTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PettyCashTransactionResource extends Resource
{
    use HasUnitScoping;

    protected static ?string $model = PettyCashTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static string|\UnitEnum|null $navigationGroup = 'Accounting';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'voucher_number';

    public static function form(Schema $schema): Schema
    {
        return PettyCashTransactionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PettyCashTransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PettyCashTransactionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPettyCashTransactions::route('/'),
            'create' => CreatePettyCashTransaction::route('/create'),
            'view'   => ViewPettyCashTransaction::route('/{record}'),
            'edit'   => EditPettyCashTransaction::route('/{record}/edit'),
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
