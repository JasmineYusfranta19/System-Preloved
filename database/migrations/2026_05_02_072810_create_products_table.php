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
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(1);
            $table->enum('condition', ['new', 'like_new', 'good', 'fair'])->default('good');
            $table->string('size')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->enum('gender', ['men', 'women', 'unisex', 'kids'])->nullable();
            $table->enum('status', ['active', 'sold', 'inactive'])->default('active');
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};