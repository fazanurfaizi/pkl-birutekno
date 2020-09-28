<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('project_id')->unsigned();            
            $table->string('subject');
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->enum('status', ['open', 'onProgress', 'closed'])->default('open');
            $table->text('response')->nullable();
            $table->timestamp('started_at')->nullable();	        
            $table->timestamp('ended_at')->nullable();	        
            $table->timestamps();
            $table->softDeletes();

            // Table Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
