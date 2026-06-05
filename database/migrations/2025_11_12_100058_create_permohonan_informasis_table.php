<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_informasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->string('nama');
            $table->string('file_identitas'); // Akan menyimpan path ke file
            $table->text('alamat_ktp');
            $table->text('alamat_sekarang')->nullable();
            $table->string('no_hp');
            $table->string('email');
            $table->string('informasi');
            $table->string('tujuan');
            $table->string('cara_memperoleh');
            $table->string('cara_mendapatkan');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_informasis');
    }
};
