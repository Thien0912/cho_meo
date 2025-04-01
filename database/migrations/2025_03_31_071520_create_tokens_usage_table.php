<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensUsageTable extends Migration
{
    public function up()
    {
        Schema::create('tokens_usage', function (Blueprint $table) {
            $table->id();
            $table->integer('tokens_used')->default(0); // Số token đã sử dụng
            $table->timestamps(); // Lưu thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('tokens_usage');
    }
}
