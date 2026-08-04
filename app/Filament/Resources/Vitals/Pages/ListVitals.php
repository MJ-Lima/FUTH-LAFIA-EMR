<?php

namespace App\Filament\Resources\Vitals\Pages;

use Filament\Schemas\Schema;


use App\Filament\Resources\Vitals\VitalsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVitals extends ListRecords
{
    protected static string $resource = VitalsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
