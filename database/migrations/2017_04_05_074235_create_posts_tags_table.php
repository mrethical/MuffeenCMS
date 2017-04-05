<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
        Schema::create('posts_tags_relation', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('tag_id');
        });
        Schema::table('posts_tags_relation', function(Blueprint $table)
        {
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');
            $table->foreign('tag_id')
                ->references('id')->on('posts_tags')
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
        Schema::table('posts_tags_relation', function(Blueprint $table)
        {
            $table->dropForeign('posts_tags_relation_tag_id_foreign');
            $table->dropForeign('posts_tags_relation_post_id_foreign');
        });
        Schema::dropIfExists('posts_tags_relation');
        Schema::dropIfExists('posts_tags');
    }
}
