<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInventoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_inventory_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('com_id');
            $table->unsignedInteger('proinv_id');
            $table->unsignedInteger('proinv_sell_id')->nullable();
            $table->unsignedInteger('pro_id');
            $table->unsignedInteger('buy_id');
            $table->unsignedInteger('sell_id')->nullable();
            $table->string('slno')->nullable();
            $table->tinyInteger('sell_status')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('entry_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('product_inventory_details');
    }
}
