<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitaApiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visita_apiarios', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('tem_comida')->default(false);
            $table->boolean('tem_sombra')->default(false);
            $table->boolean('tem_agua')->default(false);
            $table->date('data_visita');
            $table->string('observacao')->nullable(true);

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
        Schema::dropIfExists('visita_apiarios');
    }
}
