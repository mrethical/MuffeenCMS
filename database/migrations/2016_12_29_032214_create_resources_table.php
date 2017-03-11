<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->unsignedInteger('category_id')->nullable();
            $table->string('title');
            $table->string('alt', 1024);
            $table->decimal('size', 11);
            $table->string('ext');
            $table->unsignedInteger('uploaded_by');
            $table->timestamps();
        });
        Schema::table('resources', function(Blueprint $table)
        {
            $table->foreign('category_id')
                ->references('id')->on('resources_categories')
                ->onDelete('set null');
            $table->foreign('uploaded_by')
                ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
