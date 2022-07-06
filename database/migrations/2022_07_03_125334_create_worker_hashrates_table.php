<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerHashratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_hashrates', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_worker')->unsigned();
            $table->foreign('id_worker')->references('id')->on('workers')->onDelete('cascade');

            $table->date('date')->index();
            $table->float('hashrate');

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
        Schema::dropIfExists('worker_hashrates');
    }
}
