<?php

namespace App\Filament\Resources\RadiologyModalities\Pages;

use Filament\Schemas\Schema;


use App\Filament\Resources\RadiologyModalities\RadiologyModalityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRadiologyModalities extends ListRecords
{
    protected static string $resource = RadiologyModalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
