<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id('user_id'); // Auto-increment ID
                $table->string('first_name', 50);
                $table->string('last_name', 50);
                $table->string('email', 50)->unique();
                $table->string('mobile', 20);
                $table->integer('level');
                $table->string('randomstring', 100);
                $table->string('password', 100);
                $table->rememberToken();
                $table->timestamps();
            });
       }
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
};
