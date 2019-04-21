<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('department_id')->after('year')->default(0);
        });
        foreach(App\User::all() as $user) {
            if($user->department == '経済学部') {
                $department_id = 1;
            } else if ($user->department == '経営学部') {
                $department_id = 2;
            } else if ($user->department == '教育学部' || $user->major == '学校教育課程') {
                $department_id = 3;
            } else if ($user->department == '都市科学部' || $user->major == '人間文化課程' || $user->major == '建築都市・環境系学科') {
                $department_id = 4;
            } else if (is_null($user->department)) {
                $department_id = 0;
            } else {
                $department_id = 5;
            }
            $user->department_id = $department_id;
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        
    }
}
