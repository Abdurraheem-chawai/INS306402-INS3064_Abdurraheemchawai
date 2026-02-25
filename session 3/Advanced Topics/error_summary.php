<?php
// Initialize errors array
$errors = [];

// Validate form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Example validations
    if (empty($_POST['name'] ?? '')) {
        $errors['name'] = 'Name is required';
    }
    
    if (empty($_POST['email'] ?? '')) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email format is invalid';
    }
    
    if (empty($_POST['password'] ?? '')) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($_POST['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Summary</title>
    <style>
        .error-summary {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: none;
        }
        
        .error-summary.show {
            display: block;
        }
        
        .error-summary h4 {
            margin-top: 0;
        }
        
        .error-summary ul {
            margin-bottom: 0;
            padding-left: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        .form-group input.invalid {
            border-color: #dc3545;
            background-color: #fff5f5;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
            display: none;
        }
        
        .error-message.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Form with Error Summary</h1>
        
        <!-- Error Summary Block -->
        <?php if (!empty($errors)): ?>
        <div class="error-summary show">
            <h4>Please fix the following errors:</h4>
            <ul>
                <?php foreach ($errors as $field => $message): ?>
                    <li><?php echo htmlspecialchars($message); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <!-- Form -->
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                    class="<?php echo isset($errors['name']) ? 'invalid' : ''; ?>"
                >
                <?php if (isset($errors['name'])): ?>
                    <div class="error-message show">
                        <?php echo htmlspecialchars($errors['name']); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    class="<?php echo isset($errors['email']) ? 'invalid' : ''; ?>"
                >
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message show">
                        <?php echo htmlspecialchars($errors['email']); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    class="<?php echo isset($errors['password']) ? 'invalid' : ''; ?>"
                >
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message show">
                        <?php echo htmlspecialchars($errors['password']); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>