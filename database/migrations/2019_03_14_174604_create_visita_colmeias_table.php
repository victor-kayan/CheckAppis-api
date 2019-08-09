<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitaColmeiasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('visita_colmeias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('tem_abelhas_mortas')->default(false);
            $table->integer('qtd_quadros_mel');
            $table->integer('qtd_quadros_polen');
            $table->integer('qtd_cria_aberta');
            $table->integer('qtd_cria_fechada');
            $table->string('observacao')->nullable(true);
            $table->string('tem_postura');

            $table->unsignedInteger('colmeia_id');
            $table->foreign('colmeia_id')
                ->references('id')
                ->on('colmeias');

            $table->unsignedInteger('visita_apiario_id');
            $table->foreign('visita_apiario_id')
                ->references('id')
                ->on('visita_apiarios')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('visita_colmeias');
    }
}
