<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('breeds', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên giống
            $table->text('description')->nullable(); // Thông tin giống
            $table->string('image')->nullable(); // Đường dẫn ảnh
            $table->enum('type', ['dog', 'cat']); // Loại: chó hoặc mèo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('breeds');
    }
};