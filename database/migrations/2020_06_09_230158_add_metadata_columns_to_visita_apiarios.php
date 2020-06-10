<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetadataColumnsToVisitaApiarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visita_apiarios', function (Blueprint $table) {
            $table->integer('qtd_quadros_mel')->nullable();
            $table->integer('qtd_quadros_polen')->nullable();
            $table->integer('qtd_cria_aberta')->nullable();
            $table->integer('qtd_cria_fechada')->nullable();
            $table->integer('qtd_quadros_vazios')->nullable();
            $table->integer('qtd_colmeias_com_postura')->nullable();
            $table->integer('qtd_colmeias_com_abelhas_mortas')->nullable();
            $table->integer('qtd_colmeias_com_zangao')->nullable();
            $table->integer('qtd_colmeias_com_realeira')->nullable();
            $table->integer('qtd_colmeias_sem_postura')->nullable();
            $table->integer('qtd_colmeias_sem_abelhas_mortas')->nullable();
            $table->integer('qtd_colmeias_sem_zangao')->nullable();
            $table->integer('qtd_colmeias_sem_realeira')->nullable();
            $table->integer('qtd_quadros_analizados')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visita_apiarios', function (Blueprint $table) {
            $table->dropColumn('qtd_quadros_mel');
            $table->dropColumn('qtd_quadros_polen');
            $table->dropColumn('qtd_cria_aberta');
            $table->dropColumn('qtd_cria_fechada');
            $table->dropColumn('qtd_quadros_vazios');
            $table->dropColumn('qtd_colmeias_com_postura');
            $table->dropColumn('qtd_colmeias_com_abelhas_mortas');
            $table->dropColumn('qtd_colmeias_com_zangao');
            $table->dropColumn('qtd_colmeias_com_realeira');
            $table->dropColumn('qtd_colmeias_sem_postura');
            $table->dropColumn('qtd_colmeias_sem_abelhas_mortas');
            $table->dropColumn('qtd_colmeias_sem_zangao');
            $table->dropColumn('qtd_colmeias_sem_realeira');
            $table->dropColumn('qtd_quadros_analizados');
        });
    }
}
