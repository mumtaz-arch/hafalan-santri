<?php
// db_seed.php - Secure database seeding script for cPanel deployment
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
    
    // Run database seeders
    $exitCode = $kernel->call('db:seed', ['--force' => true]);
    
    if ($exitCode === 0) {
        echo "✅ Database seeding berhasil dijalankan!\n";
        echo "Status: " . ($exitCode === 0 ? "Berhasil" : "Gagal") . "\n";
        echo "\nCATATAN PENTING: Hapus file ini segera setelah digunakan untuk alasan keamanan!\n";
    } else {
        throw new Exception("Database seeding failed with exit code: $exitCode");
    }

} catch (Exception $e) {
    echo "❌ Terjadi kesalahan: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    
    // Log the full error for debugging
    error_log("Database seeding error: " . $e->getMessage());
}
?>