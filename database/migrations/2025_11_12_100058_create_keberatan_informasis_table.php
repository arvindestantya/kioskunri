<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keberatan_informasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->string('nama');
            $table->string('file_identitas'); // Akan menyimpan path ke file
            $table->text('alamat_sekarang');
            $table->string('telepon', 20);
            $table->string('email');
            $table->string('informasi');
            $table->string('tujuan');
            $table->string('alasan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keberatan_informasis');
    }
};
