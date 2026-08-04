<?php

namespace App\Filament\Resources\LabPanels\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\LabPanels\LabPanelResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLabPanel extends ViewRecord
{
    protected static string $resource = LabPanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
