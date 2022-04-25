<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();
			
			$table->string('name', 100)->unique();
			$table->string('slug', 100)->unique();
			$table->string('image');
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
        Schema::dropIfExists('categories');
    }
}
