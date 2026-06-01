<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieildsToListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('height')->nullable();
            $table->string('max_height')->nullable();
            $table->string('min_height')->nullable();
            $table->string('sath_janwar')->nullable();
            $table->boolean('rate_on_call')->default(false);
            $table->boolean('khasi')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn(['height', 'max_height', 'min_height', 'sath_janwar', 'rate_on_call', 'khasi']);
        });
    }
}
