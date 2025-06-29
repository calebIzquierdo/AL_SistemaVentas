<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailVerifiedAtToUsuarioTable extends Migration
{
    public function up()
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable()->after('correo');
        });
    }

    public function down()
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
    }
}
