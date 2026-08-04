<?php

namespace App\Filament\Resources\ClinicalNotes\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\ClinicalNotes\ClinicalNoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClinicalNote extends ViewRecord
{
    protected static string $resource = ClinicalNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
