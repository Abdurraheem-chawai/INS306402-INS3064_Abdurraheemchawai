<?php

function fmt(float $amt, string $c = '$'): string {
    return $c . number_format($amt, 2);
}

// Example usage
echo fmt(50);  // Output: "$50.00"