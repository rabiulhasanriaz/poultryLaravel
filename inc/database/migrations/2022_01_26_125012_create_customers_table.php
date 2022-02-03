<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->string('cus_name');
            $table->string('cus_com_name')->nullable();
            $table->string('cus_mobile');
            $table->string('cus_email')->nullable();
            $table->string('cus_address')->nullable();
            $table->string('cus_website')->nullable();
            $table->tinyInteger('cus_type')->default(1)->comment('1=genral , 2 cask customer');
            $table->tinyInteger('cus_customer_type')->default(1)->comment('1=local 2 =global');
            $table->tinyInteger('cus_status')->default(1);
            $table->string('entry_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
