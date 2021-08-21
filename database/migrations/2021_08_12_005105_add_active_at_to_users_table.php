<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveAtToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'active_at'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('active_at')->nullable()->after('active');
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
        if (Schema::hasColumn('users', 'active_at'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('active_at');
            });
        }
    }
}
