<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('foto')->nullable(true);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(true);
            $table->string('password')->nullable(true);
            $table->string('tecnico_id')->nullable(true);

            $table->unsignedInteger('endereco_id');
            $table->foreign('endereco_id')
                ->references('id')
                ->on('enderecos');

            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
