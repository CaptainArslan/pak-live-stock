<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToListing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->boolean('verified')->nullable()->after('khasi');
            $table->boolean('warrenty')->nullable()->after('verified');
        });
    }
    
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn(['verified', 'warrenty']);
        });
    }
}
