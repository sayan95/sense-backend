<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapists', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->nullable();
            //$table->bigIncrements('reg_id');
            $table->string('email')->uniqe();
            $table->string('password');
            $table->boolean('profile_created')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('logged_in_at')->nullable();
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
        Schema::dropIfExists('therapists');
    }
}
