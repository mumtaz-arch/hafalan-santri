<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hafalans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_surah');
            $table->integer('nomor_surah');
            $table->integer('jumlah_ayat');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hafalans');
    }
};