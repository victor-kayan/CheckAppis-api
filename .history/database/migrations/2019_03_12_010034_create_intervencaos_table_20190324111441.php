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
        Schema::create('intervencaos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->string('tecnico_id')->nullable(true);

            $table->unsignedInteger('apiario_id');
            $table->foreign('apiario_id')
                ->references('id')
                ->on('apiarios');

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
        Schema::dropIfExists('intervencaos');
    }
}
