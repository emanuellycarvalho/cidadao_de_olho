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
        Schema::create('deputado_reembolso_mensal', function (Blueprint $table) {
            $table->unsignedBigInteger('deputado_id');
            $table->year('ano');
            $table->integer('mes');
            $table->double('valor', 10, 2);
            $table->dateTime('updated_at');

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
        Schema::dropIfExists('deputado_reembolso_mensal');
    }
};
