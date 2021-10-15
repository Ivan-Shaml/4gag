<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('meme_id');
            $table->unsignedInteger('user_id');
            $table->longText('comment_text');
            $table->unsignedInteger('up_votes_count')->default(0);
            $table->unsignedInteger('down_votes_count')->default(0);
            $table->timestamps();
            $table->foreign('meme_id')
                ->references('id')
                ->on('memes')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
