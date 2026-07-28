<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasColumn('categories', 'icon')) {
            Schema::table('categories', function (Blueprint $table) {
                // Menyimpan ikon berupa teks/emoji pendek
                $table->string('icon', 10)->nullable()->after('name'); 
            });
        }
    }
    public function down(): void {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};