<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiariosTable extends Migration
{
    public function up()
    {
        Schema::create('apiarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('descricao');
            $table->string('latitude');
            $table->string('longitude');

            $table->unsignedInteger('apicultor_id');
            $table->foreign('apicultor_id')
                ->references('id')
                ->on('users');

            $table->unsignedInteger('tecnico_id');
            $table->foreign('tecnico_id')
                ->references('id')
                ->on('users');

            $table->unsignedInteger('endereco_id')->nullable(true);
            $table->foreign('endereco_id')
                    ->references('id')
                    ->on('enderecos')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('apiarios');
    }
}
