<?php

namespace App\Filament\Resources\Departments\Pages;

use Filament\Schemas\Schema;
use App\Filament\Resources\Departments\DepartmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;
}
