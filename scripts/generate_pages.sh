#!/bin/bash
# Generates the standard 4 Filament page class stubs for all new resources.
set -e
BASE="/home/z/my-project/futh-lafia-emr/app/Filament/Resources"

# format: "Folder:Model:ResourceClass"
ITEMS=(
"Appointments:Appointment:AppointmentResource"
"ClinicalNotes:ClinicalNote:ClinicalNoteResource"
"Vitals:Vitals:VitalsResource"
"Allergies:Allergy:AllergyResource"
"Diagnoses:Diagnosis:DiagnosisResource"
"LabPanels:LabPanel:LabPanelResource"
"LabTests:LabTest:LabTestResource"
"LabOrders:LabOrder:LabOrderResource"
"RadiologyModalities:RadiologyModality:RadiologyModalityResource"
"RadiologyOrders:RadiologyOrder:RadiologyOrderResource"
"DrugCategories:DrugCategory:DrugCategoryResource"
"Drugs:Drug:DrugResource"
"DrugBatches:DrugBatch:DrugBatchResource"
"DrugInteractions:DrugInteraction:DrugInteractionResource"
"Suppliers:Supplier:SupplierResource"
"Purchases:Purchase:PurchaseResource"
"Receipts:Receipt:ReceiptResource"
"DispensingPoints:DispensingPoint:DispensingPointResource"
"Prescriptions:Prescription:PrescriptionResource"
"DispensingLogs:DispensingLog:DispensingLogResource"
"StockMovements:StockMovement:StockMovementResource"
"StockReturns:StockReturn:StockReturnResource"
)

for entry in "${ITEMS[@]}"; do
    IFS=':' read -r folder model resource <<< "$entry"
    pages_dir="$BASE/$folder/Pages"
    mkdir -p "$pages_dir"
    ns="App\\Filament\\Resources\\$folder"

    # Pluralize for List class name
    if [[ "$model" == *s ]]; then plural="${model}es"; else plural="${model}s"; fi
    # Patch specific irregulars
    case "$model" in
        Allergy) plural="Allergies" ;;
    esac

    cat > "$pages_dir/List${plural}.php" <<EOF
<?php

namespace $ns\\Pages;

use App\\Filament\\Resources\\$folder\\$resource;
use Filament\\Actions\\CreateAction;
use Filament\\Resources\\Pages\\ListRecords;

class List${plural} extends ListRecords
{
    protected static string \$resource = $resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
EOF

    cat > "$pages_dir/Create${model}.php" <<EOF
<?php

namespace $ns\\Pages;

use App\\Filament\\Resources\\$folder\\$resource;
use Filament\\Resources\\Pages\\CreateRecord;

class Create${model} extends CreateRecord
{
    protected static string \$resource = $resource::class;
}
EOF

    cat > "$pages_dir/Edit${model}.php" <<EOF
<?php

namespace $ns\\Pages;

use App\\Filament\\Resources\\$folder\\$resource;
use Filament\\Actions\\DeleteAction;
use Filament\\Actions\\ViewAction;
use Filament\\Resources\\Pages\\EditRecord;

class Edit${model} extends EditRecord
{
    protected static string \$resource = $resource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
EOF

    cat > "$pages_dir/View${model}.php" <<EOF
<?php

namespace $ns\\Pages;

use App\\Filament\\Resources\\$folder\\$resource;
use Filament\\Actions\\EditAction;
use Filament\\Resources\\Pages\\ViewRecord;

class View${model} extends ViewRecord
{
    protected static string \$resource = $resource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
EOF
done

echo "Generated all page stubs."
ls "$BASE" | wc -l
