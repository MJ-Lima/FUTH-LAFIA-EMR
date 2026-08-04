#!/bin/bash
# Generates simple Policies for all new modules.
# Each policy: viewAny/view/create/update/delete/restore/forceDelete.
# Filament-shield will generate permissions per resource automatically.
set -e
BASE="/home/z/my-project/futh-lafia-emr/app/Policies"

declare -A MODELS=(
    ["Appointment"]="Appointment"
    ["ClinicalNote"]="ClinicalNote"
    ["Vitals"]="Vitals"
    ["Allergy"]="Allergy"
    ["Diagnosis"]="Diagnosis"
    ["LabPanel"]="LabPanel"
    ["LabTest"]="LabTest"
    ["LabOrder"]="LabOrder"
    ["RadiologyModality"]="RadiologyModality"
    ["RadiologyOrder"]="RadiologyOrder"
    ["DrugCategory"]="DrugCategory"
    ["Drug"]="Drug"
    ["DrugBatch"]="DrugBatch"
    ["DrugInteraction"]="DrugInteraction"
    ["Supplier"]="Supplier"
    ["Purchase"]="Purchase"
    ["Receipt"]="Receipt"
    ["DispensingPoint"]="DispensingPoint"
    ["Prescription"]="Prescription"
    ["DispensingLog"]="DispensingLog"
    ["StockMovement"]="StockMovement"
    ["StockReturn"]="StockReturn"
)

for policy in "${!MODELS[@]}"; do
    model="${MODELS[$policy]}"
    cat > "$BASE/${policy}Policy.php" <<EOF
<?php

namespace App\\Policies;

use App\\Models\\${model};
use App\\Models\\User;
use Illuminate\\Auth\\Access\\HandlesAuthorization;

class ${policy}Policy
{
    use HandlesAuthorization;

    public function viewAny(User \$user): bool
    {
        return true;
    }

    public function view(User \$user, ${model} \$record): bool
    {
        return true;
    }

    public function create(User \$user): bool
    {
        return true;
    }

    public function update(User \$user, ${model} \$record): bool
    {
        return true;
    }

    public function delete(User \$user, ${model} \$record): bool
    {
        return true;
    }

    public function restore(User \$user, ${model} \$record): bool
    {
        return true;
    }

    public function forceDelete(User \$user, ${model} \$record): bool
    {
        return true;
    }
}
EOF
done

echo "Generated $(ls "$BASE" | wc -l) policy files."
ls "$BASE"
