<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->string('genre');
            $table->string('challenges');
            $table->text('team_credit');
            $table->text('biography');
            $table->text('video_link');
            $table->integer('vimeo_video_id');
            $table->integer('featured');
            $table->integer('video_thumbnail');
            $table->text('likes');
            $table->text('most_likes');
            $table->text('credit_and_contributer');
            $table->text('is_feature');
            $table->text('duration');
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
        Schema::dropIfExists('films');
    }
}
