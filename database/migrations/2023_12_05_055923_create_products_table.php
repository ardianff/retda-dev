<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Menambahkan kolom user_id
            $table->string('title');
            $table->string('price');
            $table->string('product_code');
            $table->text('description');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users'); // Membuat foreign key
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};