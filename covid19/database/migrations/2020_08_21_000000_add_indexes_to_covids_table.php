<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToCovidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds read-path indexes so admin listing/export queries stay fast
     * as the table grows. Additive only — no existing columns change.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('covids', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('Result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('covids', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['Result']);
        });
    }
}