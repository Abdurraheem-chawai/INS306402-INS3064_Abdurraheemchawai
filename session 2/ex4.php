<?php
$string = '25.50';

// Cast string to float
$float = (float)$string;
echo gettype($float) . "(" . $float . "), ";

// Cast float to int
$int = (int)$float;
echo gettype($int) . "(" . $int . ")";
?>