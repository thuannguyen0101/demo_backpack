<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('project_id');
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->double('ios_cost')->default(0)->comment("Man month cost of system on ios platform");
            $table->double('android_cost')->default(0)->comment("Man month cost of system on android platform");
            $table->double('web_cost')->default(0)->comment("Man month cost of system on web platform");
            $table->double('total_cost');
            $table->unsignedBigInteger('user_id');
            $table->string('username');
            $table->string('memo')->nullable();

            $table->timestamps();

            //  This foreign key between projects table - systems table
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
        Schema::dropIfExists('systems');
    }
}
