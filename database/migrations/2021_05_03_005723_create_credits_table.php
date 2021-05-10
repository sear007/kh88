<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('requestId')->uniqid();
            $table->string('payment');
            $table->string('credit');
            $table->string('beforeCredit');
            $table->string('outStandingCredit');
            $table->string('lastPayment');
            $table->string('transaction')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('credits');
    }
}
