<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id('id_kembali');

            $table->unsignedBigInteger('id_pinjam');

            $table->foreign('id_pinjam')
                ->references('id_pinjam')
                ->on('peminjamen')
                ->cascadeOnDelete();

            $table->date('tanggal_kembali');
            $table->string('kondisi_alat');
            $table->decimal('denda', 12, 2)->default(0);
            $table->string('diterima_oleh');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};