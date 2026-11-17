<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_peminjamen', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_pinjam');
            $table->unsignedBigInteger('id_alat');

            $table->foreign('id_pinjam')
                ->references('id_pinjam')
                ->on('peminjamen')
                ->cascadeOnDelete();

            $table->foreign('id_alat')
                ->references('id_alat')
                ->on('alats')
                ->cascadeOnDelete();

            $table->integer('jumlah')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamen');
    }
};