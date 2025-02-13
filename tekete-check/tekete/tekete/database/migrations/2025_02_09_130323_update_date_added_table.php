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
        // Update the date_added column where it is '0000-00-00'
        DB::table('company')
            ->where('date_added', '0000-00-00')
            ->update(['date_added' => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, you can define how to revert this change if needed
        // For example, you might want to set it back to '0000-00-00' or handle it differently
        // This is left empty for now
        
    }
};
