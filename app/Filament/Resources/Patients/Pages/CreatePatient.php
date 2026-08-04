<?php

namespace App\Filament\Resources\Patients\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;
}
