<?php
session_start();

// Initialize session data
if (!isset($_SESSION['form_data'])) {
    $_SESSION['form_data'] = [];
}

$current_step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$total_steps = 3;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Merge current step data
    $_SESSION['form_data'] = array_merge($_SESSION['form_data'], $_POST);
    
    // Validation
    if ($current_step === 1 && empty($_POST['first_name'])) {
        $error = "First name is required";
    } elseif ($current_step === 2 && empty($_POST['email'])) {
        $error = "Email is required";
    } elseif ($current_step === 3) {
        // Final submission
        saveRegistration($_SESSION['form_data']);
        session_destroy();
        header("Location: confirmation.php");
        exit;
    }
    
    if (!isset($error)) {
        $current_step++;
    }
}

// Go to previous step
if (isset($_POST['prev_step'])) {
    $current_step--;
}

function saveRegistration($data) {
    // Save to database or file
    file_put_contents('registrations.txt', json_encode($data) . PHP_EOL, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Wizard - Step <?php echo $current_step; ?></title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { padding: 8px; width: 100%; box-sizing: border-box; }
        button { padding: 10px 20px; margin-right: 10px; cursor: pointer; }
        .progress { background: #ddd; height: 20px; margin-bottom: 20px; }
        .progress-bar { background: #4CAF50; height: 100%; width: <?php echo ($current_step / $total_steps) * 100; ?>%; }
        .error { color: red; margin: 10px 0; }
    </style>
</head>
<body>

<h2>Registration Wizard</h2>
<div class="progress">
    <div class="progress-bar"></div>
</div>
<p>Step <?php echo $current_step; ?> of <?php echo $total_steps; ?></p>

<?php if (isset($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="POST">
    <!-- Hidden inputs for data persistence -->
    <?php foreach ($_SESSION['form_data'] as $key => $value): ?>
        <input type="hidden" name="<?php echo htmlspecialchars($key); ?>" value="<?php echo htmlspecialchars($value); ?>">
    <?php endforeach; ?>

    <?php if ($current_step === 1): ?>
        <h3>Personal Information</h3>
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($_SESSION['form_data']['first_name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($_SESSION['form_data']['last_name'] ?? ''); ?>" required>
        </div>

    <?php elseif ($current_step === 2): ?>
        <h3>Contact Information</h3>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['form_data']['email'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Phone:</label>
            <input type="tel" name="phone" value="<?php echo htmlspecialchars($_SESSION['form_data']['phone'] ?? ''); ?>" required>
        </div>

    <?php elseif ($current_step === 3): ?>
        <h3>Review & Confirm</h3>
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['first_name']); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['last_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['phone']); ?></p>
    <?php endif; ?>

    <div>
        <?php if ($current_step > 1): ?>
            <button type="submit" name="prev_step" value="1">← Previous</button>
        <?php endif; ?>
        
        <?php if ($current_step < $total_steps): ?>
            <button type="submit">Next →</button>
        <?php else: ?>
            <button type="submit">Complete Registration</button>
        <?php endif; ?>
    </div>
</form>

</body>
</html>