<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitaColmeiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visita_colmeias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('temAbelhasMortas')->default(false);
            $table->integer('qtdQuadrosMel');
            $table->integer('qtdQuadrosPolen');
            $table->integer('qtdCriaAberta');
            $table->integer('qtdCriaFechada');
            $table->date('data_visita');

            $table->unsignedInteger('colmeia_id');
            $table->foreign('colmeia_id')
                ->references('id')
                ->on('colmeias');

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
        Schema::dropIfExists('visita_colmeias');
    }
}