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
        Schema::table('guests', function (Blueprint $table) {
            // Menambahkan kolom no_identitas setelah kolom 'id'
            $table->string('no_identitas')->unique()->nullable()->after('id');

            // Menambahkan kolom nama_fakultas setelah kolom 'jenis_pengunjung'
            // Dibuat nullable() artinya boleh kosong, cocok untuk tamu 'umum'
            $table->string('nama_fakultas')->nullable()->after('jenis_pengunjung');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // Method 'down' untuk membatalkan perubahan jika diperlukan (rollback)
            $table->dropColumn(['no_identitas', 'nama_fakultas']);
        });
    }
};