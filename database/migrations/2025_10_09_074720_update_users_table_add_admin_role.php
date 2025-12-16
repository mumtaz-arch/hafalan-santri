<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the role enum to include 'admin'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('santri', 'ustad', 'admin')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum without 'admin'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('santri', 'ustad')");
    }
};