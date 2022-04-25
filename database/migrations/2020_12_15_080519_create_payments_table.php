<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
			$table->id();			
			
			$table->integer('users_id');
			$table->integer('carts_id');
			$table->string('transaction_id', 50)->nullable();
			$table->string('auth_code', 50)->nullable();
			$table->decimal('amount', 8, 2);
			$table->string('currency');
			$table->string('payment_status');
			$table->enum('payment_type', ['authorize', 'venmo'])->default('authorize');
			$table->enum('is_progress', ['0', '1'])->default('0');
			$table->enum('is_admin_cancle', ['0', '1'])->default('0');
			$table->integer('order_status')->default('1');
			$table->enum('is_refund', ['0', '1'])->default('0');
			
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
        Schema::dropIfExists('payments');
    }
}
