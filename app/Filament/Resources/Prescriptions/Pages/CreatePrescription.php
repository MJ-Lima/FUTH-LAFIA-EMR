<?php

namespace App\Filament\Resources\Prescriptions\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\Prescriptions\PrescriptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePrescription extends CreateRecord
{
    protected static string $resource = PrescriptionResource::class;
}
