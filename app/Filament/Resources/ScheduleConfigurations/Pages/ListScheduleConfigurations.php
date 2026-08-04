<?php

namespace App\Filament\Resources\ScheduleConfigurations\Pages;

use App\Filament\Resources\ScheduleConfigurations\ScheduleConfigurationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScheduleConfigurations extends ListRecords
{
    protected static string $resource = ScheduleConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
