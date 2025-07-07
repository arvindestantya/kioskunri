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
        $table->foreignId('faculty_id')->nullable()->constrained()->onDelete('set null');
    });

    Schema::table('guests', function (Blueprint $table) {
        $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
    });

    Schema::table('flyers', function (Blueprint $table) {
        $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
    });
    
    Schema::table('feedbacks', function (Blueprint $table) {
        $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
    });
}
// (Anda juga perlu membuat method down() untuk membatalkan perubahan ini)

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
