<?php

class ArithmeticCalculator {
    private float $num1;
    private float $num2;
    private string $operation;

    public function __construct($num1, $num2, $operation) {
        $this->num1 = $this->validateNumeric($num1);
        $this->num2 = $this->validateNumeric($num2);
        $this->operation = (string)$operation;
    }

    private function validateNumeric($value): float {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException("Invalid numeric input: $value");
        }
        return (float)$value;
    }

    public function calculate(): float {
        return match($this->operation) {
            '+' => $this->num1 + $this->num2,
            '-' => $this->num1 - $this->num2,
            '*' => $this->num1 * $this->num2,
            '/' => $this->num2 != 0 ? $this->num1 / $this->num2 : throw new InvalidArgumentException("Division by zero"),
            '%' => $this->num2 != 0 ? $this->num1 % $this->num2 : throw new InvalidArgumentException("Modulo by zero"),
            default => throw new InvalidArgumentException("Unknown operation: {$this->operation}")
        };
    }
}

// HTML Form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $num1 = $_POST['num1'] ?? '';
        $num2 = $_POST['num2'] ?? '';
        $operation = $_POST['operation'] ?? '';

        $calculator = new ArithmeticCalculator($num1, $num2, $operation);
        $result = $calculator->calculate();
        $message = "Result: " . htmlspecialchars((string)$result);
    } catch (Exception $e) {
        $message = "Error: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Arithmetic Calculator</title>
</head>
<body>
    <h1>Calculator</h1>
    <form method="POST">
        <input type="number" name="num1" step="any" placeholder="Number 1" required>
        <select name="operation" required>
            <option value="">Select Operation</option>
            <option value="+">Addition (+)</option>
            <option value="-">Subtraction (-)</option>
            <option value="*">Multiplication (*)</option>
            <option value="/">Division (/)</option>
            <option value="%">Modulo (%)</option>
        </select>
        <input type="number" name="num2" step="any" placeholder="Number 2" required>
        <button type="submit">Calculate</button>
    </form>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
</body>
</html>