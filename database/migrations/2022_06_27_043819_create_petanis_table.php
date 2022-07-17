<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetanisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petanis', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('kelompok_tani_id');
            $table->integer('nik', false, 20);
            $table->string('name');
            $table->string('alamat');
            $table->string('telp', 13);
            $table->string('foto');
            $table->string('status');
            $table->timestamps();
            $table->foreign('kelompok_tani_id')->references('id')->on('kelompok_tanis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petanis');
    }
}
