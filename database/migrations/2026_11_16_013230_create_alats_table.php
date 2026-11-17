<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->id('id_alat');

            $table->unsignedBigInteger('kategori_id')->nullable();

            $table->foreign('kategori_id')
                ->references('id_kategori')
                ->on('kategoris')
                ->nullOnDelete();

            $table->string('nama_alat');
            $table->integer('stok')->default(0);
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};