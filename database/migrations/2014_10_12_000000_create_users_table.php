<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('foto')->nullable(true);
            $table->string('email')->unique();
            $table->string('password')->nullable(true);
            $table->string('telefone')->nullable(true);
            $table->string('tecnico_id')->nullable(true);
            $table->timestamp('email_verified_at')->nullable(true);

            $table->unsignedInteger('endereco_id')->nullable(true);
            $table->foreign('endereco_id')
                ->references('id')
                ->on('enderecos')->onDelete('cascade');

            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
