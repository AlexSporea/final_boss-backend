<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('adjudicatorEs');
            $table->string('adjudicatorEu');
            $table->string('authorityEs')->default("");
            $table->string('descriptionEs')->default("");
            $table->string('entityEs')->default("");
            $table->string('nameEs')->default("");
            $table->string('startDate')->default("");
            $table->string('typeEs')->default("");

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
        Schema::dropIfExists('admin_eventos');
    }
}
