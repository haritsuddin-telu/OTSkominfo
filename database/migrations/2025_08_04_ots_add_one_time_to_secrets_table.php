<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('secrets', function (Blueprint $table) {
            $table->boolean('one_time')->default(true)->after('used');
        });
    }

    public function down(): void
    {
        Schema::table('secrets', function (Blueprint $table) {
            $table->dropColumn('one_time');
        });
    }
};
