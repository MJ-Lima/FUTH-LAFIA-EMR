<?php

namespace App\Filament\Resources\DrugInteractions\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\DrugInteractions\DrugInteractionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDrugInteraction extends CreateRecord
{
    protected static string $resource = DrugInteractionResource::class;
}
