<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
			
			$table->string('name');
			$table->enum('status', ['0', '1'])->default('1');			
			
            $table->timestamps();
        });
		
		DB::table('order_statuses')->insert([
			'name' => 'Order Pending'
		]);
		
		DB::table('order_statuses')->insert([
			'name' => 'Order Completed'
		]);
		
		DB::table('order_statuses')->insert([
			'name' => 'Order Canceled'
		]);
		
		DB::table('order_statuses')->insert([
			'name' => 'Order Returned'
		]);
		
		DB::table('order_statuses')->insert([
			'name' => 'Order Ready for Delivery'
		]);
		
		DB::table('order_statuses')->insert([
			'name' => 'Order Payment Refunded'
		]);
		
		DB::table('order_statuses')->insert([
			'name' => 'Order in Progress'
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_statuses');
    }
}
