<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccBankInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_bank_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('bank_id');
            $table->string('branch_name');
            $table->string('account_name');
            $table->string('account_no');
            $table->date('open_date')->comment('bank account open date');
            $table->tinyInteger('account_type')->default(1)->comment('1=bank,2-cash');
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
        Schema::dropIfExists('acc_bank_infos');
    }
}
