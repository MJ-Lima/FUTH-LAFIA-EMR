<?php

namespace App\Filament\Resources\DispensingPoints\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DispensingPoints\DispensingPointResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDispensingPoints extends ListRecords
{
    protected static string $resource = DispensingPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
