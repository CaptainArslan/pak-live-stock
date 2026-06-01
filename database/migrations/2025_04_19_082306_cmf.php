<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cmf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmf', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('fcm_token')->nullable(); // FCM Token, can be nullable
            $table->timestamps(); // Optional: adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('cmf');
    }
}
