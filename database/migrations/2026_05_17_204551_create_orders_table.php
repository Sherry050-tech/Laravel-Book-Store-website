<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->text('address')->nullable();
            $table->decimal('subtotal', 8, 2);
            $table->decimal('shipping', 8, 2)->default(0);
            $table->decimal('total', 8, 2);
            $table->enum('status', ['pending','confirmed','shipped','delivered','cancelled'])->default('pending');
            $table->string('payment_method')->default('cod');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};