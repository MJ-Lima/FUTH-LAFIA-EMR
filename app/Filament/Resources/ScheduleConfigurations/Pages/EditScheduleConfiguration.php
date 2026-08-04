<?php

namespace App\Filament\Resources\ScheduleConfigurations\Pages;

use App\Filament\Resources\ScheduleConfigurations\ScheduleConfigurationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditScheduleConfiguration extends EditRecord
{
    protected static string $resource = ScheduleConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
