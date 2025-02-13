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
        if (!Schema::hasTable('company')) {
            Schema::create('company', function (Blueprint $table) {
                $table->id('company_id'); // Primary key
                $table->string('c_name', 50)->notNull(); // Company name
                $table->string('c_email', 50)->notNull(); // Company email
                $table->string('c_type', 50)->notNull(); // Company type
                $table->date('date_added')->default(DB::raw('CURRENT_TIMESTAMP')); // Date added
                $table->string('admin_no', 50)->notNull(); // Admin number
                $table->string('password', 50)->notNull(); // Password
                $table->string('random', 100)->notNull(); // Random string
                $table->timestamps(); // Created at and updated at timestamps
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
        Schema::dropIfExists('company');
    }
};
