<?php

namespace App\Filament\Resources\ClinicalNotes\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\ClinicalNotes\ClinicalNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClinicalNotes extends ListRecords
{
    protected static string $resource = ClinicalNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
