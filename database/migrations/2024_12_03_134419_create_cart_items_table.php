<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id'); // Foreign key column
            $table->string('product_name');
            $table->decimal('price', 8, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 8, 2);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('cart_id')
                ->references('id')
                ->on('cart') // Ensure the table name matches 'cart'
                ->onDelete('cascade'); // Ensure cascading delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
