<?php

namespace App\Filament\Resources\LabPanels\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\LabPanels\LabPanelResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLabPanel extends EditRecord
{
    protected static string $resource = LabPanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
