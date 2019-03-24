<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('temComida')->default(false);
            $table->boolean('temSombra')->default(false);
            $table->boolean('temAgua')->default(false);
            $table->boolean('temAbelhasMortas')->default(false);
            $table->int('qtdQuadrosMel');
            $table->int('qtdQuadrosPolen');
            $table->int('qtdCriaAberta');
            $table->int('qtdCriaFechada');
            $table->date('data_visita');

            $table->unsignedInteger('colmeia_id');
            $table->foreign('colmeia_id')
                ->references('id')
                ->on('colmeias');
                
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
        Schema::dropIfExists('visitas');
    }
}
