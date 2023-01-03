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
        Schema::create('deputado_redes_sociais', function (Blueprint $table) {
            $table->unsignedBigInteger('rede_id');
            $table->unsignedBigInteger('deputado_id');
            $table->boolean('active')->default(true);
            $table->dateTime('updated_at');
            
            $table->foreign('rede_id')->references('id')->on('redes_sociais');
            $table->foreign('deputado_id')->references('id')->on('deputados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deputado_redes_sociais');
    }
};
