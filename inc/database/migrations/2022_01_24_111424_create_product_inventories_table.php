<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->tinyInteger('party_id')->nullable();
            $table->tinyInteger('exp_id')->nullable();
            $table->tinyInteger('prodet_id')->nullable();
            $table->tinyInteger('project_id')->nullable();
            $table->string('invoice_no');
            $table->decimal('total_qty',8,2)->default(0);
            $table->decimal('short_qty',8,2)->default(0);
            $table->string('short_remarks')->nullable();
            $table->decimal('qty')->default(0);
            $table->decimal('unit_price')->default(0);
            $table->decimal('debit')->default(0);
            $table->decimal('credit')->default(0);
            $table->date('issue_date');
            $table->string('barcode')->nullable();
            $table->date('exp_date')->nullable();
            $table->string('tran_desc')->nullable();
            $table->tinyInteger('deal_type')->comment('1=supplier,2=customer');
            $table->tinyInteger('tran_type')->comment('1=buy/sell product, 2=refund buy/sell product, 3=opening-balance/deposit-withdraw balance,4=supplier-payment/customer-payment-collection,5=supplier-payment-collection/customer-payment-refund');
            $table->tinyInteger('confirm')->default(0);
            $table->unsignedInteger('sell_ref')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('edit_count')->default(1)->comment('0=not edit , 1 edited');
            $table->tinyInteger('damage_status')->default(0);
            $table->tinyInteger('entry_by')->nullable();
            $table->tinyInteger('updated_by')->nullable();
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
        Schema::dropIfExists('product_inventories');
    }
}
