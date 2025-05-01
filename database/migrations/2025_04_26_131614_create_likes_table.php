<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['user_id', 'post_id']); // Đảm bảo mỗi user chỉ like 1 lần/bài
        });

        // Thêm cột likes vào bảng posts
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('likes')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('likes');
        });

        Schema::dropIfExists('likes');
    }
};