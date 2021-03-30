<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackingAndDeliveryAtToOrdenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordenes', function($table) {
            $table->string('tracking')->nullable();
            $table->timestamp('delivery_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordenes', function($table) {
            $table->dropColumn('tracking');
            $table->dropColumn('delivery_at');
        });
    }
}
