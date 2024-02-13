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
        // i need to update the chat table to add a column for chat is read or not
        Schema::table('chat', function (Blueprint $table) {
            $table->boolean('is_read')->default(false)->after('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('chat', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
    }
};
