<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost';
$dbname = 'travel_agency';
$username = 'root';
$password = '';

// Connection options for better reliability
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    PDO::ATTR_TIMEOUT => 10, // 10 second timeout
];

// Try different connection methods
$connection_successful = false;
$hosts_to_try = ['localhost', '127.0.0.1'];

foreach ($hosts_to_try as $try_host) {
    try {
        // First, try to connect to MySQL server without specifying database
        $pdo = new PDO("mysql:host=$try_host", $username, $password, $options);
        
        // Check if database exists
        $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
        if ($stmt->rowCount() == 0) {
            // Database doesn't exist, create it
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            if (isset($_GET['debug'])) {
                echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px; border-radius: 5px; border: 1px solid #c3e6cb;'>
                        <strong>Database Created!</strong> The database '$dbname' has been created successfully using host: $try_host
                      </div>";
            }
        }
        
        // Now connect to the specific database
        $pdo = new PDO("mysql:host=$try_host;dbname=$dbname;charset=utf8mb4", $username, $password, $options);
        
        // Check if tables exist
        $stmt = $pdo->query("SHOW TABLES");
        if ($stmt->rowCount() == 0) {
            // No tables exist, import the database structure
            $sql_file = __DIR__ . '/../database/travel_agency.sql';
            if (file_exists($sql_file)) {
                $sql = file_get_contents($sql_file);
                // Remove the CREATE DATABASE and USE statements since we're already connected
                $sql = preg_replace('/CREATE DATABASE.*?;/i', '', $sql);
                $sql = preg_replace('/USE.*?;/i', '', $sql);
                $pdo->exec($sql);
                if (isset($_GET['debug'])) {
                    echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px; border-radius: 5px; border: 1px solid #c3e6cb;'>
                            <strong>Database Tables Created!</strong> The database structure has been imported successfully using host: $try_host
                          </div>";
                }
            } else {
                if (isset($_GET['debug'])) {
                    echo "<div style='background: #fff3cd; color: #856404; padding: 15px; margin: 10px; border-radius: 5px; border: 1px solid #ffeaa7;'>
                            <strong>Warning:</strong> Database file not found at: $sql_file
                          </div>";
                }
            }
        }
        
        $connection_successful = true;
        break; // Exit the loop if connection is successful
        
    } catch(PDOException $e) {
        // Continue to next host if this one fails
        continue;
    }
}

if (!$connection_successful) {
    $error_message = "Failed to connect to MySQL server using any of the tried hosts: " . implode(', ', $hosts_to_try);
    
    // Display error with troubleshooting steps
    echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; margin: 20px; border-radius: 5px; border: 1px solid #f5c6cb;'>
            <h3>🚨 Database Connection Error</h3>
            <p><strong>Error:</strong> $error_message</p>
            
            <h4>🔧 Troubleshooting Steps:</h4>
            <ol>
                <li><strong>Start XAMPP:</strong> Open XAMPP Control Panel and start Apache and MySQL services</li>
                <li><strong>Check MySQL Port:</strong> Ensure MySQL is running on port 3306</li>
                <li><strong>Verify Credentials:</strong> Default XAMPP credentials are username: 'root', password: '' (empty)</li>
                <li><strong>Test Connection:</strong> Visit <a href='simple_test.php'>simple_test.php</a> to test different connection methods</li>
                <li><strong>Manual Setup:</strong> Create database manually in phpMyAdmin if needed</li>
            </ol>
            
            <h4>🚀 Quick Fix:</h4>
            <p>1. Open XAMPP Control Panel</p>
            <p>2. Click 'Start' next to MySQL</p>
            <p>3. Click 'Start' next to Apache</p>
            <p>4. Open phpMyAdmin (http://localhost/phpmyadmin)</p>
            <p>5. Create a new database named 'travel_agency'</p>
            <p>6. Import the SQL file from database/travel_agency.sql</p>
            
            <h4>🔗 Useful Links:</h4>
            <ul>
                <li><a href='http://localhost/phpmyadmin' target='_blank'>phpMyAdmin</a></li>
                <li><a href='simple_test.php' target='_blank'>Connection Test</a></li>
                <li><a href='test_connection.php' target='_blank'>Full Diagnostic Tool</a></li>
            </ul>
          </div>";
    
    // Set $pdo to null so the rest of the application can handle it gracefully
    $pdo = null;
}
?> 