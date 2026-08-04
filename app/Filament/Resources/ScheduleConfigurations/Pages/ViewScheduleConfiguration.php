<?php

namespace App\Filament\Resources\ScheduleConfigurations\Pages;

use App\Filament\Resources\ScheduleConfigurations\ScheduleConfigurationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewScheduleConfiguration extends ViewRecord
{
    protected static string $resource = ScheduleConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
