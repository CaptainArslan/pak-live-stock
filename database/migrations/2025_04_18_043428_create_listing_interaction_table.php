<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingInteractionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_interaction', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('listing_id');
        $table->unsignedBigInteger('view_count')->default(0);
        $table->unsignedBigInteger('contact_clicks')->default(0);
        $table->unsignedBigInteger('share_clicks')->default(0);
        $table->timestamps();

        $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_interaction');
    }
}
