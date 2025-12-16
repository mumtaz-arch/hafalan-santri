<?php
// laravel_setup.php - Complete Laravel setup script for cPanel deployment
// IMPORTANT: Delete this file immediately after use for security!

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DS', DIRECTORY_SEPARATOR);

function logMessage($message) {
    echo $message . "<br>\n";
    flush();
    ob_flush();
}

function runArtisanCommand($command, $params = []) {
    static $kernel = null;
    
    if ($kernel === null) {
        // Check if Laravel is properly installed
        if (!file_exists(__DIR__ . DS . 'vendor' . DS . 'autoload.php')) {
            throw new Exception('Laravel vendor autoload not found. Please make sure you uploaded vendor folder.');
        }
        
        // Include Laravel components
        require_once __DIR__ . DS . 'vendor' . DS . 'autoload.php';
        
        // Check if Laravel app files exist
        if (!file_exists(__DIR__ . DS . 'bootstrap' . DS . 'app.php')) {
            throw new Exception('Laravel bootstrap/app.php not found.');
        }
        
        // Create Laravel application instance
        $app = require_once __DIR__ . DS . 'bootstrap' . DS . 'app.php';
        
        // Create artisan kernel
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
    }
    
    // Run the command
    $exitCode = $kernel->call($command, $params);
    
    return [
        'exit_code' => $exitCode,
        'output' => $kernel->output()
    ];
}

try {
    logMessage("🚀 Starting Laravel setup process...");
    
    // 1. Generate application key
    logMessage("🔐 Generating application key...");
    $result = runArtisanCommand('key:generate', ['--force' => true]);
    if ($result['exit_code'] === 0) {
        logMessage("✅ Application key generated successfully!");
    } else {
        throw new Exception("Failed to generate application key. Error: " . $result['output']);
    }
    
    // 2. Run database migrations
    logMessage("🏗️ Running database migrations...");
    $result = runArtisanCommand('migrate', ['--force' => true]);
    if ($result['exit_code'] === 0) {
        logMessage("✅ Database migrations completed successfully!");
    } else {
        // Check if the error is due to already migrated tables
        if (strpos($result['output'], 'already exists') !== false) {
            logMessage("⚠️  Migrations already run (or tables already exist). This may be OK.");
        } else {
            throw new Exception("Failed to run migrations. Error: " . $result['output']);
        }
    }
    
    // 3. Run database seeders (optional)
    logMessage("🌱 Running database seeders...");
    $result = runArtisanCommand('db:seed', ['--force' => true]);
    if ($result['exit_code'] === 0) {
        logMessage("✅ Database seeding completed successfully!");
    } else {
        logMessage("⚠️  Database seeding may have failed. Error: " . $result['output']);
        // Don't throw exception here as seeding might not be critical
    }
    
    // 4. Optimize cache
    logMessage("⚡ Clearing and caching configuration...");
    runArtisanCommand('config:clear');
    $result = runArtisanCommand('config:cache');
    if ($result['exit_code'] === 0) {
        logMessage("✅ Configuration cached successfully!");
    } else {
        logMessage("⚠️  Configuration caching may have failed: " . $result['output']);
    }
    
    logMessage("⚡ Clearing and caching routes...");
    runArtisanCommand('route:clear');
    $result = runArtisanCommand('route:cache');
    if ($result['exit_code'] === 0) {
        logMessage("✅ Routes cached successfully!");
    } else {
        logMessage("⚠️  Route caching may have failed: " . $result['output']);
    }
    
    logMessage("⚡ Clearing and caching views...");
    runArtisanCommand('view:clear');
    $result = runArtisanCommand('view:cache');
    if ($result['exit_code'] === 0) {
        logMessage("✅ Views cached successfully!");
    } else {
        logMessage("⚠️  View caching may have failed: " . $result['output']);
    }
    
    logMessage("🎉 Laravel setup completed successfully!");
    logMessage("<br><strong style='color: red;'>⚠️ IMPORTANT: DELETE THIS FILE IMMEDIATELY FOR SECURITY!</strong>");
    logMessage("📋 Next steps: 1) Delete this file 2) Verify your application works 3) Check file permissions");

} catch (Exception $e) {
    logMessage("❌ Setup failed: " . $e->getMessage());
    logMessage("File: " . $e->getFile());
    logMessage("Line: " . $e->getLine());
    
    // Log the full error for debugging
    error_log("Laravel setup error: " . $e->getMessage());
    
    logMessage("<br><strong style='color: red;'>⚠️ IMPORTANT: DELETE THIS FILE IMMEDIATELY FOR SECURITY!</strong>");
}
?>