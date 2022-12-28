<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 50);
            $table->text('deskripsi')->nullable();
            $table->integer('author');
            $table->integer('kategori');
            $table->string('penerbit', 50);
            $table->integer('tahun_terbit');
            $table->string('kota_terbit', 50);
            $table->integer('rating_umur');
            $table->string('edisi', 30)->nullable();
            $table->text('sampul');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku');
    }
};
