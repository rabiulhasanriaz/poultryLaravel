<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->string('company_name');
            $table->string('address');
            $table->string('person');
            $table->string('mobile');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('complain_number');
            $table->unsignedInteger('due_balance');
            $table->tinyInteger('balance_type');
            $table->tinyInteger('type')->comments('1=regular,2-irregular,3=importer');
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('entry_by');
            $table->unsignedInteger('update_by');
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
        Schema::dropIfExists('suppliers');
    }
}
