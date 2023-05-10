<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('users', function (Blueprint $table) {
    $table->string('email',255)->change();
});

Schema::table('personal_access_tokens', function (Blueprint $table) {
    $table->dropIndex('token');
    $table->string('token',255)->change();
});
