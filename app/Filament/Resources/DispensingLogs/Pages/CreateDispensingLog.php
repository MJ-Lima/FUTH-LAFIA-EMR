<?php

namespace App\Filament\Resources\DispensingLogs\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DispensingLogs\DispensingLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDispensingLog extends CreateRecord
{
    protected static string $resource = DispensingLogResource::class;
}
