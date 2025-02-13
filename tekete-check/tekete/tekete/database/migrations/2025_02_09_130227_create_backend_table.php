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
        if (!Schema::hasTable('backend'))  {
            Schema::create('backend', function (Blueprint $table) {
                $table->id();
                $table->string('status', 50);
                $table->unsignedBigInteger('tick_id');
                $table->unsignedBigInteger('technician_id')->nullable();
                $table->foreign('tick_id')->references('tick_id')->on('incidents')->onDelete('cascade');
                $table->foreign('technician_id')->references('technician_id')->on('technician')->onDelete('set null');
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
        Schema::dropIfExists('backend');
    }
};
