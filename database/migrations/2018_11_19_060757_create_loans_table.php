<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->decimal('duration')->default(0);
            $table->date('repayment_frequency')->nullable();
            $table->decimal('interest_rate')->default(0);
            $table->decimal('arrangement_fee')->default(0);
            $table->decimal('loan_amount')->default(0);
            $table->decimal('loan_balance')->default(0);
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
        Schema::dropIfExists('loans');
    }
}
