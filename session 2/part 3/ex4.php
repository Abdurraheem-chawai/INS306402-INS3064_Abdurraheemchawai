<?php

function safeDiv(float $a, float $b): ?float {
    if ($b == 0) {
        return null;
    }
    return $a / $b;
}

// Test cases
$input = safeDiv(10, 0);
var_dump($input); // Output: null

$input = safeDiv(10, 2);
var_dump($input); // Output: float(5)

$input = safeDiv(15, 3);
var_dump($input); // Output: float(5)