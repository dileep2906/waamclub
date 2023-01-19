<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile');
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('home_address')->nullable();
            $table->string('current_address')->nullable();
            $table->string('nearest_hub')->nullable();;
            $table->string('landmark')->nullable();;
            $table->string('password');
            $table->string('enc_pass');
            $table->string('agent_id')->unique();
            $table->string('dob')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
           
            $table->string('pan_number')->nullable();
            $table->string('pan_image')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('ifcs_code')->nullable();
            $table->string('branch')->nullable();
            $table->string('bank_holder_name')->nullable();
            $table->string('upi_number')->nullable();
            $table->string('adhar_number')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('signature_image')->nullable();
            $table->string('user_type')->nullable();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('is_enabled')->default(0)->comment("0 is disabled user, 1 is active");
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('agents');
    }
};
