<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapistProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapist_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone')->unique();
            $table->string('gender');
            $table->json('education');
            $table->json('experties');
            $table->json('age_group');
            $table->json('therapist_profile');
            $table->json('language_proficiency');
            $table->json('spectrum_specialization');
            $table->timestamps();
        });

        // foreign key
        Schema::table('therapist_profiles', function (Blueprint $table) {
            $table->bigInteger('therapist_id')->unsigned();
            $table->foreign('therapist_id')
                    ->references('id')
                    ->on('therapists')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('therapist_profiles');
    }
}
