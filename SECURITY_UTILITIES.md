# Laravel Utility Scripts for cPanel Deployment

These PHP scripts are designed to help you run Laravel Artisan commands on shared hosting environments that don't provide SSH/terminal access (like cPanel).

## Available Scripts

1. **key_generate.php** - Generates application key
2. **migrate_run.php** - Runs database migrations
3. **db_seed.php** - Runs database seeders
4. **cache_optimize.php** - Clears and caches config, routes, and views

## Security Instructions

⚠️ **IMPORTANT**: For security reasons:
- Delete ALL these files immediately after use
- Never leave these files accessible on production servers
- These files provide direct access to your application's internals

## How to Use

1. Upload the necessary script to your application's root directory
2. Access the script via your browser (e.g., yourdomain.com/key_generate.php)
3. Check the output to confirm successful operation
4. Immediately delete the script file after use

## Troubleshooting

If you get a 500 error:
- Check your server's error logs in cPanel
- Ensure your Laravel installation is complete (vendor folder, etc.)
- Verify your .env file is properly configured
- Confirm your PHP version meets Laravel requirements (PHP 8.1+)

## Laravel Application Security

After deployment:
- Delete all temporary utility scripts (key_generate.php, migrate_run.php, etc.)
- Set proper file permissions in cPanel File Manager
- Ensure .env file is not accessible via web browser
- Remove any debug output from production site