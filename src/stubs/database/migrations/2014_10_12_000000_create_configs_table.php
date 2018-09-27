<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('android_version');
            $table->string('ios_version');
            $table->text('languages');
            $table->string('contact_mail')->nullable();
            $table->string('faq_url')->nullable();
            $table->string('terms_url')->nullable();
            $table->string('privacy_url')->nullable();
            $table->string('deep_link_url')->nullable();
            $table->boolean('app_in_maintenance')->default(false);
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
        Schema::dropIfExists('configs');
    }
}
