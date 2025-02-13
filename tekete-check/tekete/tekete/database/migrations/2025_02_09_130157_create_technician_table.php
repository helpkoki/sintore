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
        if (!Schema::hasTable('technician')) {
            Schema::create('technician', function (Blueprint $table) {
                $table->id('technician_id');
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
        Schema::dropIfExists('technician');
    }
};
