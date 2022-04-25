<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
			$table->id();
			
			$table->enum('store_online', ['0', '1'])->default('0');
			$table->enum('store_modal', ['0', '1'])->default('0');
			$table->text('store_offline_message')->nullable();
			
			$table->time('start_time')->nullable();
			$table->time('close_time')->nullable();
			
			$table->time('start_time_second')->nullable();
			$table->time('close_time_second')->nullable();
			
			$table->text('linkedin')->nullable();
			$table->text('instagram')->nullable();
			$table->text('tiktok')->nullable();
			
			$table->decimal('store_tax', 8, 2);
			$table->decimal('delivery_charges', 8, 2);
			
			$table->string('delivery_time')->default('Students Served');
			$table->string('students_served')->default('1296 students');
			
			$table->enum('promocode_show', ['0', '1'])->default('0');
			$table->string('promocode_text')->nullable();
			$table->string('promocode')->nullable();
			$table->text('promocode_message')->nullable();
			
			$table->string('low_quantity')->default('1');
			$table->string('order_limit')->default('10');
			

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
        Schema::dropIfExists('settings');
    }
}
