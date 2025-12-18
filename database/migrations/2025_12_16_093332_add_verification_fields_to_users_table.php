<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('verified');
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();

            // Foreign key constraint for verified_by
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });

        // Update all existing ustad accounts to have verified status
        \DB::statement("UPDATE users SET verification_status = 'verified' WHERE role = 'ustad'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraint if exists (using Laravel convention name)
            if (\DB::getSchemaBuilder()->hasTable('users')) {
                try {
                    $table->dropForeign(['verified_by']);
                } catch (\Exception $e) {
                    // Foreign key constraint might not exist or have different name, ignore
                }
            }

            $table->dropColumn(['verification_status', 'verified_at', 'verified_by']);
        });
    }
};
