<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionsVisitaColmeiaForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visita_colmeias', function (Blueprint $table) {
            $table->integer('qtd_quadros_vazios')->after('qtd_cria_fechada');
            $table->string('tem_zangao')->after('tem_postura');
            $table->string('tem_realeira')->after('tem_postura');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visita_colmeias', function (Blueprint $table) {
            $table->dropColumn('qtd_quadros_vazios');
            $table->dropColumn('tem_zangao');
            $table->dropColumn('tem_realeira');
        });
    }
}
