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
        Schema::create('citation_messenger_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('citation_id')->comment("What citation has been sent");
            $table->foreign('citation_id')->references('id')->on('citations');

            $table->unsignedBigInteger('messenger_id')->comment("What messenger has been used");
            $table->foreign('messenger_id')->references('id')->on('messengers');

            $table->unsignedBigInteger('user_id')->comment("Who has sent citation");
            $table->foreign('user_id')->references('id')->on('users');

            $table->text('address')->comment('Address od recipient');

            $table->unsignedTinyInteger('status')->default('1')->comment('Status of sending: 1 - try to sender, 2 - failed, 3 - success');

            $table->timestamps();
        });

        \DB::statement("ALTER TABLE `citation_messenger_user` COMMENT 'Sendings of messages with citations'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citation_messenger_user');
    }
};
