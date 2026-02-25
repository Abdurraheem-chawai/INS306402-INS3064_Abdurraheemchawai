<?php
// Controller to handle GET vs POST method toggling
class MethodToggleController {
    
    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = [];
        
        if ($method === 'GET') {
            $data = $_GET;
            $methodType = 'GET';
        } elseif ($method === 'POST') {
            $data = $_POST;
            $methodType = 'POST';
        }
        
        $this->displayForm($methodType, $data);
    }
    
    private function displayForm($methodType, $data) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>GET vs POST Toggle</title>
            <style>
                body { font-family: Arial; margin: 20px; }
                .container { max-width: 600px; }
                .method-box { border: 2px solid #333; padding: 15px; margin: 10px 0; }
                .get { border-color: #0066cc; background: #e6f2ff; }
                .post { border-color: #cc0000; background: #ffe6e6; }
                button { padding: 10px 20px; margin: 5px; cursor: pointer; }
                pre { background: #f5f5f5; padding: 10px; overflow-x: auto; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>GET vs POST Request Method Toggle</h1>
                
                <div class="method-box get">
                    <h3>GET Request Form</h3>
                    <form method="GET">
                        <input type="text" name="username" placeholder="Username">
                        <input type="email" name="email" placeholder="Email">
                        <button type="submit">Send via GET</button>
                    </form>
                </div>
                
                <div class="method-box post">
                    <h3>POST Request Form</h3>
                    <form method="POST">
                        <input type="text" name="username" placeholder="Username">
                        <input type="email" name="email" placeholder="Email">
                        <button type="submit">Send via POST</button>
                    </form>
                </div>
                
                <div class="method-box">
                    <h3>Current Request: <?php echo $methodType; ?></h3>
                    <p><strong>Data received via $_<?php echo $methodType; ?></strong></p>
                    <pre><?php echo htmlspecialchars(print_r($data, true)); ?></pre>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}

// Initialize and run controller
$controller = new MethodToggleController();
$controller->handleRequest();
?>