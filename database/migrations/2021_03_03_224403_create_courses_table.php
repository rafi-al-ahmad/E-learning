<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('categore');
            $table->string('sub_categore');
            $table->string('topic');
            $table->string('description');
            $table->string('level');
            $table->string('language');
            $table->json('price');
            $table->string('image');
            $table->string('promotional_video');
            $table->json('settings');
            $table->string('status');
            $table->string('student_learn');
            $table->string('requierments');
            $table->string('targeted_students');
            $table->string('created_at');
            $table->string('updated_at');
            $table->string('instractorId');
            $table->string('rate');
            $table->json('enrolled_students');
            $table->string('videos_duration');
            $table->json('top_ten_review');
            $table->json('sections');
            /**
             * name
             * goals
             * order
             * Items[{id, type,title,descriptioin,status, order,  },{}]
             */
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
        Schema::dropIfExists('courses');
    }
}

