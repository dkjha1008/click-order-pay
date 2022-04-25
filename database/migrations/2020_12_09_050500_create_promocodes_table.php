<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
			
			$table->string('promocode');
			$table->date('start_date');
			$table->date('expire_date');
			$table->enum('coupon_type', ['percentage', 'fixed'])->default('percentage');
			$table->string('discount');
			$table->integer('uses_limit');
			$table->enum('new_users', ['no', 'yes'])->default('no');
			$table->enum('status', ['0', '1'])->default('0');
			$table->enum('is_delete', ['0', '1'])->default('0');
			
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
        Schema::dropIfExists('promocodes');
    }
}
