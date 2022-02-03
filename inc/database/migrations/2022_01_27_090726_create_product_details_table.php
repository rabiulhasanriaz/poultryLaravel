<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('type_id')->nullable();
            $table->string('supplier')->nullable();
            $table->string('pro_name')->nullable();
            $table->decimal('buy_price',12,2);
            $table->decimal('sell_price',12,2);
            $table->tinyInteger('pro_warranty')->default(0)->comment('0=not warrenty');
            $table->string('pro_description')->nullable();
            $table->tinyInteger('available_qty')->default(0);
            $table->tinyInteger('short_qty')->nullable();
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
        Schema::dropIfExists('product_details');
    }
}
