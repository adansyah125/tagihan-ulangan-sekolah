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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_tagihan', ['UTS', 'UAS'])->default('UTS');
            $table->decimal('nominal', 10, 2);
            $table->string('tahun_ajaran');
            $table->date('tgl_tagihan');
            $table->date('jatuh_tempo');
            $table->enum('status', ['Buka', 'Tutup'])->default('Buka');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
