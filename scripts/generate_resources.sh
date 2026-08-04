#!/bin/bash
# Generates the main {Model}Resource.php file for each module.
# The Form / Table / Infolist files are written separately by main agent (custom logic).
set -e
BASE="/home/z/my-project/futh-lafia-emr/app/Filament/Resources"

# format: "Folder:Model:ResourceClass:Icon:NavigationGroup"
ITEMS=(
"Appointments:Appointment:AppointmentResource:OutlinedCalendar:Appointments"
"ClinicalNotes:ClinicalNote:ClinicalNoteResource:OutlinedClipboardDocumentList:Clinical"
"Vitals:Vitals:VitalsResource:OutlinedChartBar:Clinical"
"Allergies:Allergy:AllergyResource:OutlinedExclamationTriangle:Clinical"
"Diagnoses:Diagnosis:DiagnosisResource:OutlinedClipboardDocumentCheck:Clinical"
"LabPanels:LabPanel:LabPanelResource:OutlinedBeaker:Laboratory"
"LabTests:LabTest:LabTestResource:OutlinedBeaker:Laboratory"
"LabOrders:LabOrder:LabOrderResource:OutlinedClipboardDocumentList:Laboratory"
"RadiologyModalities:RadiologyModality:RadiologyModalityResource:OutlinedViewfinderCircle:Radiology"
"RadiologyOrders:RadiologyOrder:RadiologyOrderResource:OutlinedClipboardDocumentList:Radiology"
"DrugCategories:DrugCategory:DrugCategoryResource:OutlinedTag:Pharmacy"
"Drugs:Drug:DrugResource:OutlinedBeaker:Pharmacy"
"DrugBatches:DrugBatch:DrugBatchResource:OutlinedArchiveBox:Pharmacy"
"DrugInteractions:DrugInteraction:DrugInteractionResource:OutlinedExclamationTriangle:Pharmacy"
"Suppliers:Supplier:SupplierResource:OutlinedTruck:Pharmacy"
"Purchases:Purchase:PurchaseResource:OutlinedShoppingCart:Pharmacy"
"Receipts:Receipt:ReceiptResource:OutlinedClipboardDocumentCheck:Pharmacy"
"DispensingPoints:DispensingPoint:DispensingPointResource:OutlinedBuildingStorefront:Pharmacy"
"Prescriptions:Prescription:PrescriptionResource:OutlinedClipboardDocumentList:Pharmacy"
"DispensingLogs:DispensingLog:DispensingLogResource:OutlinedArchiveBox:Pharmacy"
"StockMovements:StockMovement:StockMovementResource:OutlinedArrowsRightLeft:Pharmacy"
"StockReturns:StockReturn:StockReturnResource:OutlinedArrowUturnLeft:Pharmacy"
)

for entry in "${ITEMS[@]}"; do
    IFS=':' read -r folder model resource icon navGroup <<< "$entry"
    schemas_dir="$BASE/$folder/Schemas"
    tables_dir="$BASE/$folder/Tables"
    mkdir -p "$schemas_dir" "$tables_dir"
    ns="App\\Filament\\Resources\\$folder"

    # Plural model name (for class references)
    case "$model" in
        Allergy) pluralModel="Allergies" ;;
        Diagnosis) pluralModel="Diagnoses" ;;
        Vitals) pluralModel="Vitals" ;;
        *) pluralModel="${model}s" ;;
    esac
    formClass="${model}Form"
    infolistClass="${model}Infolist"
    tableClass="${pluralModel}Table"

    cat > "$BASE/$folder/${resource}.php" <<EOF
<?php

namespace $ns;

use App\\Filament\\Resources\\$folder\\Pages\\Create${model};
use App\\Filament\\Resources\\$folder\\Pages\\Edit${model};
use App\\Filament\\Resources\\$folder\\Pages\\List${pluralModel};
use App\\Filament\\Resources\\$folder\\Pages\\View${model};
use App\\Filament\\Resources\\$folder\\Schemas\\${formClass};
use App\\Filament\\Resources\\$folder\\Schemas\\${infolistClass};
use App\\Filament\\Resources\\$folder\\Tables\\${tableClass};
use App\\Models\\${model};
use BackedEnum;
use Filament\\Resources\\Resource;
use Filament\\Schemas\\Schema;
use Filament\\Support\\Icons\\Heroicon;
use Filament\\Tables\\Table;

class ${resource} extends Resource
{
    protected static ?string \$model = ${model}::class;

    protected static string|BackedEnum|null \$navigationIcon = Heroicon::${icon};

    protected static ?string \$navigationGroup = '${navGroup}';

    protected static ?string \$recordTitleAttribute = '${model,,}_number';

    public static function form(Schema \$schema): Schema
    {
        return ${formClass}::configure(\$schema);
    }

    public static function infolist(Schema \$schema): Schema
    {
        return ${infolistClass}::configure(\$schema);
    }

    public static function table(Table \$table): Table
    {
        return ${tableClass}::configure(\$table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => List${pluralModel}::route('/'),
            'create' => Create${model}::route('/create'),
            'view' => View${model}::route('/{record}'),
            'edit' => Edit${model}::route('/{record}/edit'),
        ];
    }
}
EOF
done

echo "Generated all resource files."
ls "$BASE" | wc -l
