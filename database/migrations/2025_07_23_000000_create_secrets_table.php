<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
   Schema::create('secrets', function (Blueprint $table) {
    $table->id();
    $table->text('text');
    $table->string('slug', 32)->unique();
    $table->timestamp('expires_at')->nullable();
    $table->boolean('used')->default(false);
    $table->timestamp('viewed_at')->nullable();
    $table->foreignId('user_id')->constrained();
    $table->timestamps();
});
    }
    public function down() {
        Schema::dropIfExists('secrets');
    }
};
