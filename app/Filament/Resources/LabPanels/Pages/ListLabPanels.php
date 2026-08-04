<?php

namespace App\Filament\Resources\LabPanels\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\LabPanels\LabPanelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLabPanels extends ListRecords
{
    protected static string $resource = LabPanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
