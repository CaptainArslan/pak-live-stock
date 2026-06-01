<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            // Modify age column (replace with years and months)
            $table->integer('age_years')->nullable();
            $table->integer('age_months')->nullable();

            // New fields
            $table->enum('gender', ['male', 'female', 'both']);
            $table->integer('suwa')->nullable();

            // Goat & Sheep specific fields
            $table->integer('quantity')->nullable();
            $table->integer('min_age_years')->nullable();
            $table->integer('min_age_months')->nullable();
            $table->integer('max_age_years')->nullable();
            $table->integer('max_age_months')->nullable();

            $table->integer('total_price')->nullable();
            $table->integer('price_per_animal')->nullable();
            $table->integer('price_per_kg')->nullable();
            
            $table->integer('min_teeth')->nullable();
            $table->integer('max_teeth')->nullable();

            $table->integer('min_weight')->nullable();
            $table->integer('max_weight')->nullable();
            
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
}
