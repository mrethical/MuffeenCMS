<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_groups', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->i;
            $table->string('name', 16);
            $table->timestamps();
        });
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedSmallInteger('menu_group_id');
            $table->string('url');
            $table->unsignedInteger('parent_id')->nullable();
            $table->timestamps();
        });
        Schema::create('menu_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id');
            $table->smallInteger('order');
            $table->timestamps();
        });
        Schema::table('menu_groups', function (Blueprint $table) {
            $table->primary('id');
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->foreign('menu_group_id')
                ->references('id')->on('menu_groups')
                ->onDelete('cascade');
            $table->foreign('parent_id')
                ->references('id')->on('menus')
                ->onDelete('set null');
        });
        Schema::table('menu_order', function (Blueprint $table) {
            $table->foreign('menu_id')
                ->references('id')->on('menus')
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
        Schema::dropIfExists('menu_order');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('menu_groups');
    }
}
