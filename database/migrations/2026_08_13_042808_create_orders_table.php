<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->enum('order_type', ['catalog', 'custom']);
        $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
        $table->text('custom_description')->nullable();
        $table->string('custom_image')->nullable();
        $table->integer('quantity');
        $table->string('customer_name');
        $table->string('customer_contact');
        $table->text('notes')->nullable();
        $table->enum('status', ['Baru', 'Diproses', 'Selesai', 'Dibatalkan'])->default('Baru');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
