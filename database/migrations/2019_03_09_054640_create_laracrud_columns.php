<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaracrudColumns extends Migration
{
    public function up()
    {
        // add columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default(config('laracrud.roles.0'));
            $table->string('timezone')->default(config('app.timezone'));
        });

        // create default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
    }

    public function down()
    {
        // remove columns from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('timezone');
        });

        // delete default admin user
        User::where('email', 'admin@example.com')->delete();
    }
}