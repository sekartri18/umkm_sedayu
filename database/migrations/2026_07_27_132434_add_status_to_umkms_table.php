<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('umkms', function (Blueprint $table) {
            // Default status adalah pending saat pertama mendaftar
            $table->enum('status', ['pending', 'approved', 'suspended'])->default('pending')->after('address');
        });
    }
    public function down(): void {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};