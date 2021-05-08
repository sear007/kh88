<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('GameType')->nullable();
            $table->string('Code')->nullable();
            $table->string('GameOCode')->nullable();
            $table->string('GameCode')->nullable();
            $table->string('GameName')->nullable();
            $table->string('Specials')->nullable();
            $table->string('Technology')->nullable();
            $table->string('SupportedPlatForms')->nullable();
            $table->string('Order')->nullable();
            $table->integer('DefaultWidth')->nullable();
            $table->integer('DefaultHeight')->nullable();
            $table->string('Image1')->nullable();
            $table->string('Image2')->nullable();
            $table->boolean('FreeSpin')->nullable();
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
        Schema::dropIfExists('games');
    }
}
