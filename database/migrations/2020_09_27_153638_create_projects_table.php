<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('user_id')->unsigned()->nullable();            
            $table->bigInteger('category_id')->unsigned();                                
            $table->string('name');            
            $table->float('estimated_budget')->default('500');
            $table->text('description');
            $table->string('status')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable(); 
            $table->timestamps();
            $table->softDeletes();

            // Tables Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
