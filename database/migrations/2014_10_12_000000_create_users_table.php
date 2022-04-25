<?php
	
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();
			
			$table->enum('role', ['admin', 'user'])->default('user');
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('otp')->nullable();
			
            $table->timestamp('verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
			
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
			
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->enum('verified', ['0', '1'])->default('1');
            $table->enum('status', ['0', '1', '2'])->default('1');
			
            $table->rememberToken();
            $table->timestamps();
        });
		
		///insert admin
		DB::table('users')->insert([
			'role' => 'admin',
			'name' => 'admin',
			'email' => 'admin@yopmail.com',
			'verified_at' => date('Y-m-d H:i:s'),
			'password' => Hash::make('kit@123%')
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
