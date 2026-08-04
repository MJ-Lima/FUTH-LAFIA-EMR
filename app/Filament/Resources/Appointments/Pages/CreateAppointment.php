<?php

namespace App\Filament\Resources\Appointments\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;
}
