<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            // Menambahkan kolom rekening bank
            $table->string('bank_name')->nullable()->after('balance');
            $table->string('bank_account')->nullable()->after('bank_name');
            $table->string('bank_owner')->nullable()->after('bank_account');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_account', 'bank_owner']);
        });
    }
};