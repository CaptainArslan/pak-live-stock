<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysAndRupesToFeaturedRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('featured_requests', function (Blueprint $table) {
            $table->unsignedInteger('days')->nullable()->after('status');
            $table->unsignedInteger('rupes')->nullable()->after('days');
        });
    }
    
    public function down()
    {
        Schema::table('featured_requests', function (Blueprint $table) {
            $table->dropColumn(['days', 'rupes']);
        });
    }
}
