<?php
// cache_optimize.php - Secure caching script for cPanel deployment
// IMPORTANT: Delete this file immediately after use for security!

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Check if Laravel is properly installed
    if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
        throw new Exception('Laravel vendor autoload not found. Please make sure you uploaded vendor folder.');
    }

    // Include Laravel components
    require_once __DIR__ . '/vendor/autoload.php';
    
    // Check if Laravel app files exist
    if (!file_exists(__DIR__ . '/bootstrap/app.php')) {
        throw new Exception('Laravel bootstrap/app.php not found.');
    }
    
    // Create Laravel application instance
    $app = require_once __DIR__ . '/bootstrap/app.php';
    
    // Create artisan kernel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Clear and cache configuration
    echo "Clearing configuration...\n";
    $kernel->call('config:clear');
    
    echo "Caching configuration...\n";
    $exitCode1 = $kernel->call('config:cache');
    
    echo "Clearing routes...\n";
    $kernel->call('route:clear');
    
    echo "Caching routes...\n";
    $exitCode2 = $kernel->call('route:cache');
    
    echo "Clearing views...\n";
    $kernel->call('view:clear');
    
    echo "Caching views...\n";
    $exitCode3 = $kernel->call('view:cache');
    
    if ($exitCode1 === 0 && $exitCode2 === 0 && $exitCode3 === 0) {
        echo "✅ Optimasi cache Laravel berhasil!\n";
        echo "\nCATATAN PENTING: Hapus file ini segera setelah digunakan untuk alasan keamanan!\n";
    } else {
        throw new Exception("One or more cache commands failed");
    }

} catch (Exception $e) {
    echo "❌ Terjadi kesalahan: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    
    // Log the full error for debugging
    error_log("Cache optimization error: " . $e->getMessage());
}
?>