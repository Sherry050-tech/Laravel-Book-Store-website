<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->decimal('price', 8, 2);
            $table->string('image')->default('default.jpg');
            $table->text('description')->nullable();
            $table->enum('category', ['bestseller','new_release','top_rated','popular','suggestion'])->default('bestseller');
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->integer('stock')->default(100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};