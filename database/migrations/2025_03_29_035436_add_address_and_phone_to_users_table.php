<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable()->after('email'); // Thêm cột 'address' sau cột 'email'
            $table->string('phone')->nullable()->after('address'); // Thêm cột 'phone' sau cột 'address'
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone']); // Xóa cột nếu rollback
        });
    }
};
