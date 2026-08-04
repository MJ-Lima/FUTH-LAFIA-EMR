#!/bin/bash
# Fix recordTitleAttribute values that referenced non-existent _number columns.
BASE="/home/z/my-project/futh-lafia-emr/app/Filament/Resources"

declare -A FIXES=(
    ["Vitals/VitalsResource.php"]='recorded_at'
    ["Allergies/AllergyResource.php"]='substance'
    ["Diagnoses/DiagnosisResource.php"]='description'
    ["LabPanels/LabPanelResource.php"]='name'
    ["LabTests/LabTestResource.php"]='name'
    ["DrugCategories/DrugCategoryResource.php"]='name'
    ["Drugs/DrugResource.php"]='name'
    ["DrugBatches/DrugBatchResource.php"]='batch_number'
    ["Suppliers/SupplierResource.php"]='name'
    ["DispensingPoints/DispensingPointResource.php"]='name'
    ["DispensingLogs/DispensingLogResource.php"]='reference_number'
)

for file in "${!FIXES[@]}"; do
    val="${FIXES[$file]}"
    sed -i "s/protected static ?string \$recordTitleAttribute = '[^']*';/protected static ?string \$recordTitleAttribute = '${val}';/" "$BASE/$file"
done

# For DrugInteraction and StockMovement — remove recordTitleAttribute entirely
for file in "DrugInteractions/DrugInteractionResource.php" "StockMovements/StockMovementResource.php"; do
    sed -i "/protected static ?string \$recordTitleAttribute = /d" "$BASE/$file"
done

echo "Done."
grep -rn "recordTitleAttribute" "$BASE" | grep -i "_number" | grep -v "appointment_number\|encounter_number\|note_number\|order_number\|purchase_number\|receipt_number\|prescription_number\|reference_number\|return_number\|batch_number" || echo "All clean."
