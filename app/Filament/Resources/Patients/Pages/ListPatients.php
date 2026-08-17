<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    public function getHeaderActions(): array
    {
        if (!auth()->user()?->can('create patient')) {
            return [];
        }
        return [CreateAction::make()];  
    }
}