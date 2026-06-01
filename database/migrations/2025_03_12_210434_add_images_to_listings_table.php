<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagesToListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('listings', function (Blueprint $table) {
        $table->longText('images')->nullable();
    });
}

public function down()
{
    Schema::table('listings', function (Blueprint $table) {
        $table->dropColumn('images');
    });
}

}
