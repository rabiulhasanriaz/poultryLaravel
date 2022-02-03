<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_bank_statements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('inventory_id')->nullable();
            $table->unsignedInteger('reference_id')->comment('customer/supplier id')->nullable();
            $table->unsignedInteger('reference_type')->comment('1=customer, 2=supplier,3=expense credit,4=expense debit, 5=contra');
            $table->unsignedInteger('bank_id')->comment('bank id from inv_acc_bank_infos table');
            $table->decimal('debit',12,2)->default(0);
            $table->decimal('credit',12,2)->default(0);
            $table->date('transaction_date');
            $table->string('voucher_no')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('contra_transaction_id')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('acc_bank_statements');
    }
}
