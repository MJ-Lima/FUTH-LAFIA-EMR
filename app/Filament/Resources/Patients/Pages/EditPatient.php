<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('update patient') ?? false;
    }

    protected function getHeaderActions(): array
    {
        $actions = [ViewAction::make()];

        if (auth()->user()?->can('delete patient')) {
            $actions[] = DeleteAction::make();
        }

        return $actions;
    }
}