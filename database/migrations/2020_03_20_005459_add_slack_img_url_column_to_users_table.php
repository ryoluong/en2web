<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlackImgUrlColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image_24')->after('avater_path')->default('/img/user_icon/48.png');
            $table->string('image_32')->after('image_24')->default('/img/user_icon/64.png');
            $table->string('image_48')->after('image_32')->default('/img/user_icon/96.png');
            $table->string('image_72')->after('image_48')->default('/img/user_icon/120.png');
            $table->string('image_192')->after('image_72')->default('/img/user_icon/240.png');
            $table->string('image_512')->after('image_192')->default('/img/user_icon/240.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image_24');
            $table->dropColumn('image_32');
            $table->dropColumn('image_48');
            $table->dropColumn('image_72');
            $table->dropColumn('image_192');
            $table->dropColumn('image_512');
        });
    }
}
