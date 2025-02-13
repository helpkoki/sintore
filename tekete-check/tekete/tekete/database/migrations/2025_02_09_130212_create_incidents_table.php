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
        if (!Schema::hasTable('incidents'))  {
            Schema::create('incidents', function (Blueprint $table) {
                $table->id('tick_id');
                $table->string('date', 50);
                $table->string('os', 50);
                $table->string('department', 50);
                $table->string('description', 100);
                $table->string('priority', 150)->nullable();
                $table->string('status', 50)->nullable();
                $table->string('path', 50)->nullable();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('technician_id')->nullable();
                $table->unsignedBigInteger('company_id');
                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
                $table->foreign('technician_id')->references('technician_id')->on('technician')->onDelete('set null');
                $table->foreign('company_id')->references('company_id')->on('company')->onDelete('cascade');
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
        Schema::dropIfExists('incidents');
    }
};
