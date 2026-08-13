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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // kode unik badge, misal BDG-POL-001
        $table->string('name');
        $table->enum('category', ['Polisi', 'Tentara', 'Pramuka', 'Custom', 'Sekolah']);
        $table->string('image')->nullable();
        $table->decimal('price', 12, 2);
        $table->string('size')->nullable(); // misal "5cm x 5cm"
        $table->text('description')->nullable();
        $table->integer('min_qty_nego')->default(0); // 0 = tidak ada opsi nego
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
