<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories', 'id')->cascadeOnDelete();
            $table->string('cover', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('title', 255);
            $table->string('excerpt', 255);
            $table->string('slug', 255)->unique();
            $table->text('content');
            $table->string('status', 255)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
