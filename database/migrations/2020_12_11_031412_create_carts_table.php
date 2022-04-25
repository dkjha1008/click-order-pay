<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();
			
			$table->integer('users_id')->nullable()->index();
			$table->string('guest_uuid')->nullable();
			$table->string('tip')->nullable();
			
			$table->text('promocode')->nullable();
			$table->string('tax')->nullable();
			$table->string('delivery_charges')->nullable();
			$table->string('price')->nullable();
			$table->string('total_price')->nullable();
			$table->enum('status', ['cart', 'paid'])->default('cart');
			
		
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
        Schema::dropIfExists('carts');
    }
}
