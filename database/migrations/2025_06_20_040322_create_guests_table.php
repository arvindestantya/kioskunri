<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_guests_table.php
public function up(): void
{
    Schema::create('guests', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('no_handphone');
        $table->string('email');
        $table->string('jenis_pengunjung');
        $table->text('perihal')->nullable();
        $table->timestamps(); // otomatis membuat kolom created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
