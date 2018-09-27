<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            // Ids
            $table->increments('id');
            $table->string('push_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('twitter_id')->nullable();

            // Personal data
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postcode')->nullable();
            $table->string('identification_number')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('photo')->nullable();

            // urls
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();

            // Permissions
            $table->boolean('is_admin')->default(false);
            $table->tinyInteger('permissions')->default(GENERIC_USER);

            // Flags & tokens
            $table->tinyInteger('os')->nullable();
            $table->string('mail_token')->nullable();
            $table->boolean('verified')->default(false);
            $table->rememberToken();
            $table->timestamps();

            // indexes
            $table->index('mail_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
