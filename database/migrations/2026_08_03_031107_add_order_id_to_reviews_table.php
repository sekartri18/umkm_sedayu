<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('reviews', function (Blueprint $table) {
            // Menambahkan kolom order_id setelah product_id
            $table->foreignId('order_id')->nullable()->after('product_id')->constrained('orders')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });
    }
};