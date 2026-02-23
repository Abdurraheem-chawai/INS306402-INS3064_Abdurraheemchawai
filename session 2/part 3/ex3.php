<?php

function isAdult(?int $age): bool {
    if ($age === null) {
        return false;
    }
    return $age >= 18;
}

// Example usage
$input = isAdult(null);
var_dump($input); // Output: False

$input = isAdult(25);
var_dump($input); // Output: True

$input = isAdult(16);
var_dump($input); // Output: False