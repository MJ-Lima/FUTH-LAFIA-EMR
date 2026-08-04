#!/usr/bin/env php
<?php
/**
 * Generates the standard 4 Filament page class stubs (List/Create/Edit/View)
 * for each resource name passed in $resources.
 * Run: php scripts/generate_filament_pages.php
 */
$base = __DIR__ . '/../app/Filament/Resources';

$resources = [
    'Appointments' => 'Appointment',
    'ClinicalNotes' => 'ClinicalNote',
    'Vitals' => 'Vitals',
    'Allergies' => 'Allergy',
    'Diagnoses' => 'Diagnosis',
    'LabPanels' => 'LabPanel',
    'LabTests' => 'LabTest',
    'LabOrders' => 'LabOrder',
    'RadiologyModalities' => 'RadiologyModality',
    'RadiologyOrders' => 'RadiologyOrder',
    'DrugCategories' => 'DrugCategory',
    'Drugs' => 'Drug',
    'DrugBatches' => 'DrugBatch',
    'DrugInteractions' => 'DrugInteraction',
    'Suppliers' => 'Supplier',
    'Purchases' => 'Purchase',
    'Receipts' => 'Receipt',
    'DispensingPoints' => 'DispensingPoint',
    'Prescriptions' => 'Prescription',
    'DispensingLogs' => 'DispensingLog',
    'StockMovements' => 'StockMovement',
    'StockReturns' => 'StockReturn',
];

foreach ($resources as $folder => $model) {
    $pagesDir = "$base/$folder/Pages";
    if (! is_dir($pagesDir)) {
        mkdir($pagesDir, 0777, true);
    }
    $ns = "App\\Filament\\Resources\\$folder";
    $resourceClass = $folder === 'Appointments' ? 'AppointmentResource' : ($model . 'Resource');

    // List
    file_put_contents("$pagesDir/List{$model}s.php", <<<PHP
<?php

namespace $ns\\Pages;

use App\\Filament\\Resources\\$folder\\$resourceClass;
use Filament\\Actions\\CreateAction;
use Filament\\Resources\\Pages\\ListRecords;

class List{$model}s extends ListRecords
{
    protected static string \$resource = $resourceClass::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
PHP
    );

    // Create
    file_put_contents("$pagesDir/Create{$model}.php", <<<PHP
<?php

namespace $ns\\Pages;

use App\\Filament\\Resources\\$folder\\$resourceClass;
use Filament\\Resources\\Pages\\CreateRecord;

class Create{$model} extends CreateRecord
{
    protected static string \$resource = $resourceClass::class;
}
PHP
    );

    // Edit
    file_put_contents("$pagesDir/Edit{$model}.php", <<<PHP
<?php

namespace $ns\\Pages;

use App\\Filament\\Resources\\$folder\\$resourceClass;
use Filament\\Actions\\DeleteAction;
use Filament\\Actions\\ViewAction;
use Filament\\Resources\\Pages\\EditRecord;

class Edit{$model} extends EditRecord
{
    protected static string \$resource = $resourceClass::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
PHP
    );

    // View
    file_put_contents("$pagesDir/View{$model}.php", <<<PHP
<?php

namespace $ns\\Pages;

use App\\Filament\\Resources\\$folder\\$resourceClass;
use Filament\\Actions\\EditAction;
use Filament\\Resources\\Pages\\ViewRecord;

class View{$model} extends ViewRecord
{
    protected static string \$resource = $resourceClass::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
PHP
    );

    echo "Generated pages for $folder ($model)\n";
}

echo "Done.\n";
