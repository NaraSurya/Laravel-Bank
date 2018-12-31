<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('member_number')->nullable();
            $table->string('ktp_number');
            $table->string('address');
            $table->string('phone_number');
            $table->enum('gender',['man','women']);
            $table->date('birth_day');
            $table->string('profile_picture');
            $table->enum('aktive',['1','0'])->default('1'); 
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('members');
    }
}
