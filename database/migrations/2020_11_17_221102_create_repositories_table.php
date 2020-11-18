<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_repositories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id', false);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('git_id');
            $table->string('name');
            $table->string('html_url');
            $table->text('description')->nullable();
            $table->string('owner_login');
            $table->integer('stargazers_count', false, true);
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
        Schema::dropIfExists('favorite_repositories');
    }
}
