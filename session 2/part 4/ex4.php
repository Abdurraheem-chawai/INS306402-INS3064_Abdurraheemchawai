<?php
// Input: Array of random integers
$scores = [65, 70, 75, 80, 85, 90, 55, 88, 92, 60];

// Calculate: Average, Max, Min
$average = array_sum($scores) / count($scores);
$max = max($scores);
$min = min($scores);

// Filter: Create new array of scores > Average
$topScores = array_filter($scores, function($score) use ($average) {
    return $score > $average;
});

// Sort for better presentation
$topScores = array_values(sort($topScores) ? $topScores : []);

// Output
echo "Avg: " . round($average, 2) . ", Max: " . $max . ", Min: " . $min . ", Top: " . json_encode(array_values($topScores));
?>