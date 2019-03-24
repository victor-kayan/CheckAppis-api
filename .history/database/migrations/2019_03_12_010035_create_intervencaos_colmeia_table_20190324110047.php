<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntervencaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervencaos_colmeias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->$string('descricao');

            $table->unsignedInteger('colmeia_id');
            $table->foreign('colmeia_id')
                ->references('id')
                ->on('colmeias');

            $table->unsignedInteger('intervencao_id');
            $table->foreign('intervencao_id')
                ->references('id')
                ->on('intervencaos');

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
        Schema::dropIfExists('intervencaos_colmeias');
    }
}
