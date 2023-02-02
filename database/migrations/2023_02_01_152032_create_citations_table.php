<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(true)
            ->comment("Who has added citation. If from console - Null");
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('citation',500)->unique()->comment('Text of citation');
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
        Schema::dropIfExists('citations');
    }
};
