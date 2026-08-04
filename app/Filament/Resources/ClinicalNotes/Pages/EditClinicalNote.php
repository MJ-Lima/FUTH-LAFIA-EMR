<?php

namespace App\Filament\Resources\ClinicalNotes\Pages;

use Filament\Schemas\Schema;

use App\Filament\Resources\ClinicalNotes\ClinicalNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditClinicalNote extends EditRecord
{
    protected static string $resource = ClinicalNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
