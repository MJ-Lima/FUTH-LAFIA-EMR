<?php

namespace App\Filament\Resources\Vitals\Pages;

use Filament\Schemas\Schema;


use App\Filament\Resources\Vitals\VitalsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVitals extends EditRecord
{
    protected static string $resource = VitalsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
