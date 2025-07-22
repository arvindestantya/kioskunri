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
        Schema::create('history_kunjungans', function (Blueprint $table) {
            $table->id();
            $table->string('no_identitas');
            $table->unsignedBigInteger('faculty_id');
            $table->timestamps();

            // Kombinasi no_identitas dan faculty_id harus unik
            $table->unique(['no_identitas', 'faculty_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_kunjungans');
    }
};
