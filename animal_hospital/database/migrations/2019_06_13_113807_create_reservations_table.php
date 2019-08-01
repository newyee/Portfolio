<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            
            $table->mediumIncrements('id');
            $table->dateTime('reservation_date');
            $table->string('owner_name',100);
            $table->string('owner_name_furigana',100);
            $table->string('animal_name',100);
            $table->string('animal_species',100);
            $table->integer('tel');
            $table->string('mailadress',100);
            $table->string('other',256);
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
        Schema::dropIfExists('reservations');
    }
}
