<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('system_id');
            $table->enum('priority',['high', 'medium', 'low'])->default('medium');
            $table->double('ios_cost')->default(0)->comment("Man month cost of requirement on ios platform");
            $table->double('android_cost')->default(0)->comment("Man month cost of requirement on android platform");
            $table->double('web_cost')->default(0)->comment("Man month cost of requirement on web platform");
            $table->double('total_cost');
            $table->string('memo')->nullable();
            $table->string('username');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            //  This foreign key between systems table - requirements table
            $table->foreign('system_id')->references('id')->on('systems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requirements');
    }
}
