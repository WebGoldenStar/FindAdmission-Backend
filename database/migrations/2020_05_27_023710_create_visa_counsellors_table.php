<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaCounsellorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_counsellors', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('country')->nullable();;
            $table->string('company')->nullable();;
            $table->string('phonenumber')->nullable();;
            $table->string('whatsapp_number')->nullable();;
            $table->string('gender')->nullable();;
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->json('specialise_countries')->nullable();
            $table->string("countries_level")->nullable();
            $table->string("training_from")->nullable();
            $table->string("training_to")->nullable();
            $table->string("training_description")->nullable();
            $table->json("speak_languages")->nullable();
            $table->decimal('totalFee', 15, 2)->nullable();
            $table->string("profile_title")->nullable();
            $table->string("profile_overview")->nullable();
            $table->string("profile_image")->nullable();
            $table->string("phone_verification_number")->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('visa_counsellors');
    }
}
