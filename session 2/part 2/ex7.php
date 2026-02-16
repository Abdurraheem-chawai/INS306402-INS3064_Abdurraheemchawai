<?php
$input = [1, 2, 3, 4, 5];
$output = [];

for ($i = count($input) - 1; $i >= 0; $i--) {
    $output[] = $input[$i];
}

print_r($output);
?>