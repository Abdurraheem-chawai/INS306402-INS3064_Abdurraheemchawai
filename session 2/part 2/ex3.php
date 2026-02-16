<?php
echo "<table border='1'>";

for ($i = 1; $i <= 5; $i++) {
    echo "<tr>";
    for ($j = 1; $j <= 5; $j++) {
        $product = $i * $j;
        echo "<td>$product</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>