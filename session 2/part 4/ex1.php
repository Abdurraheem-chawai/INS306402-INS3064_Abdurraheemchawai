<?php

function calculateBMI($kg, $m) {
    $bmi = $kg / ($m * $m);
    $bmi = round($bmi, 1);
    
    if ($bmi < 18.5) {
        $category = "Under";
    } elseif ($bmi < 25) {
        $category = "Normal";
    } else {
        $category = "Over";
    }
    
    return "BMI: $bmi ($category)";
}

// Example usage
echo calculateBMI(70, 1.75);

?>