<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('breed_id')->constrained('breeds')->onDelete('cascade'); // Nasal (Category)
            $table->integer('age');
            $table->enum('gaban', ['yes', 'no']);
            $table->integer('milk_quantity')->nullable();
            $table->integer('teeth');
            $table->decimal('weight', 10, 2);
            $table->decimal('price', 10, 2);
            $table->string('province');
            $table->string('city');
            $table->string('contact_number');
            $table->string('address');
            $table->text('detail')->nullable();
            $table->longText('images')->change();
            $table->timestamps();
            $table->boolean('is_featured')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
