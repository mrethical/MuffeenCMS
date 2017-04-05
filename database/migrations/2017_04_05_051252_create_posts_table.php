<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('resource_id')->nullable();
            $table->string('resource_attributes');
            $table->text('content');
            $table->string('slug');
            $table->unsignedInteger('author');
            $table->timestamps();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('posts_categories')
                ->onDelete('set null');
            $table->foreign('author')
                ->references('id')->on('users')
                ->onDelete('restrict');
            $table->foreign('resource_id')
                ->references('id')->on('resources')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
