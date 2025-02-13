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
        if (!Schema::hasTable('survey')) {
            Schema::create('survey', function (Blueprint $table) {
                $table->id('survey_id');
                $table->unsignedBigInteger('tick_id');
                $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->string('rate', 20);
                $table->string('comments', 200);
                $table->string('code', 100);
    
                $table->foreign('tick_id')->references('tick_id')->on('incidents')->onDelete('cascade');
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
        Schema::dropIfExists('survey');
    }
};
