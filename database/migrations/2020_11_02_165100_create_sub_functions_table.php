<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_functions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('requirement_id');
            $table->enum('priority',['high', 'medium', 'low'])->default('medium');
            $table->double('ios_cost')->default(0)->comment("Man month cost of subfunction on ios platform");
            $table->double('android_cost')->default(0)->comment("Man month cost of subfunction on android platform");
            $table->double('web_cost')->default(0)->comment("Man month cost of subfunction on web platform");
            $table->double('total_cost');
            $table->string('memo')->nullable();
            $table->string('username');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            //  This foreign key between requirements table - sub_functions table
            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_functions');
    }
}
