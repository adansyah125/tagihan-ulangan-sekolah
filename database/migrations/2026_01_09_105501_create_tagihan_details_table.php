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
        Schema::create('tagihan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tagihan_id')->constrained('tagihans')->cascadeOnDelete();
            $table->string('kd_tagihan');
            $table->decimal('nominal', 10, 2);
            $table->enum('jenis_tagihan', ['uts', 'uas'])->default('uts');
            $table->date('tgl_tagihan');
            $table->date('jatuh_tempo');
            $table->enum('status', ['belum lunas', 'lunas'])->default('belum lunas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_details');
    }
};
