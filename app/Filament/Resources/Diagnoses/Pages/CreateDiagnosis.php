<?php

namespace App\Filament\Resources\Diagnoses\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\Diagnoses\DiagnosisResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDiagnosis extends CreateRecord
{
    protected static string $resource = DiagnosisResource::class;
}
