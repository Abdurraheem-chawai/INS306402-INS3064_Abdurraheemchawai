<?php
$int = 5;
$str = '5';

// Loose comparison (==)
$looseEqual = ($int == $str);

// Strict comparison (===)
$strictEqual = ($int === $str);

// Print results
echo "Loose comparison (==): " . ($looseEqual ? "True" : "False") . "\n";
echo "Strict comparison (===): " . ($strictEqual ? "True" : "False") . "\n";

// Summary
echo "Equal (" . ($looseEqual ? "True" : "False") . "), Identical (" . ($strictEqual ? "True" : "False") . ")\n";
?>