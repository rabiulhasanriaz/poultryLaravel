<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTemporariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_temporaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('cus_id')->nullable();
            $table->unsignedInteger('pro_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->string('pro_name');
            $table->string('type_name');
            $table->decimal('short_qty',8,2)->default(0);
            $table->string('short_remarks')->nullable();
            $table->integer('qty');
            $table->string('invoice_no')->nullable();
            $table->decimal('unit_price',12,2)->default(0);
            $table->date('exp_date')->nullable();
            $table->string('slno')->nullable();
            $table->tinyInteger('deal_type');
            $table->tinyInteger('status');
            $table->tinyInteger('type')->default(1)->comment('1=non-warranty , 2=warranty');
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
        Schema::dropIfExists('product_temporaries');
    }
}
