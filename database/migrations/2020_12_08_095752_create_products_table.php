<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();
			
			$table->string('category')->nullable();
			
			$table->string('title');
			$table->string('slug');
			$table->string('image');
			$table->string('description')->nullable();
			$table->string('sku', 50);
			$table->integer('qty');
			$table->decimal('price', 8, 2);
			$table->string('tag')->nullable();
            $table->longText('nutrition_info')->nullable();
			$table->integer('reorder')->nullable();
			
			$table->enum('status', ['0', '1'])->default('1');
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
        Schema::dropIfExists('products');
    }
}
