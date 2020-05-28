<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('country')->nullable();;
            $table->string('company')->nullable();;
            $table->string('phonenumber')->nullable();;
            $table->string('whatsapp_number')->nullable();;
            $table->string('gender')->nullable();;
            $table->timestamp('birthday')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->json('study_countries')->nullable();
            $table->string("visa_type")->nullable();
            $table->string("is_travelled_country")->nullable();
            $table->string("travelled_country_detail")->nullable();
            $table->string("is_refused_country")->nullable();
            $table->string("refused_country_detail")->nullable();
            $table->string("is_deported_country")->nullable();
            $table->string("deported_country_detail")->nullable();
            $table->string("personal_circumstances")->nullable();
            $table->string("sponsoring_education")->nullable();
            $table->string("is_excluding_tuition")->nullable();
            $table->string("excluding_tuition_detail")->nullable();
            $table->string("is_received_admission")->nullable();
            $table->string("received_admission_detail")->nullable();
            $table->string("study_course")->nullable();
            
            $table->string("address")->nullable();
            $table->string("state")->nullable();
            $table->string("profile_image")->nullable();
            // $table->string("phone_verification_number")->nullable();
            // $table->timestamp('phone_verified_at')->nullable();

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
        Schema::dropIfExists('students');
    }
}
