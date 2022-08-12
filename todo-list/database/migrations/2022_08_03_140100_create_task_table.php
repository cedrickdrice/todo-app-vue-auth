<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('task_status_id')->index();
            $table->unsignedBigInteger('task_priority_id')->index();
            $table->string('task_title');
            $table->longText('task_description');
            $table->date('due_date')->nullable();
            $table->integer('task_order');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_status_id')->references('id')->on('task_status')->onDelete('cascade');
            $table->foreign('task_priority_id')->references('id')->on('task_priority')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
}
