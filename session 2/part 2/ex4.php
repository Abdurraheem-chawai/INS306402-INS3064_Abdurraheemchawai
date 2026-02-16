<?php
$input = [10, 20, 5];
$total = 0;

foreach ($input as $price) {
    $total += $price; // Accumulate the total
}

echo "Total: " . $total;
?>