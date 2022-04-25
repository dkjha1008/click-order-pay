<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_statuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->id();
			
			$table->bigInteger('users_id')->unsigned();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
			
			$table->bigInteger('payments_id')->unsigned();
            $table->foreign('payments_id')->references('id')->on('payments')->onDelete('cascade');
			
			$table->bigInteger('order_status_id')->unsigned();
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
			
			$table->text('comment')->nullable();			
			
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
        Schema::dropIfExists('payment_statuses');
    }
}
