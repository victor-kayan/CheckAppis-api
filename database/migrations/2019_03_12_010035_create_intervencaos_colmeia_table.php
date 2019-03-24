<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntervencaosColmeiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervencao_colmeias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->boolean('is_concluido');

            $table->unsignedInteger('colmeia_id');
            $table->foreign('colmeia_id')
                ->references('id')
                ->on('colmeias');

            $table->unsignedInteger('intervencao_id');
            $table->foreign('intervencao_id')
                ->references('id')
                ->on('intervencaos');

            $table->softDeletes();
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
        Schema::dropIfExists('intervencao_colmeias');
    }
}
