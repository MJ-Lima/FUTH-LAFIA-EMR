<?php

namespace App\Filament\Resources\Vitals\Pages;

use Filament\Schemas\Schema;


use App\Filament\Resources\Vitals\VitalsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVitals extends CreateRecord
{
    protected static string $resource = VitalsResource::class;
}
