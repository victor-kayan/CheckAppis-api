<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokenRelatoriosTable extends Migration
{
    public function up()
    {
        Schema::create('token_relatorios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token_relatorios');
            $table->string('tecnico_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('token_relatorios');
    }
}
