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
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug', 280)->unique();
            $table->string('sku', 60)->nullable();
            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('affiliate_link', 1000);
            $table->string('badge', 60)->nullable();
            $table->decimal('rating', 2, 1)->default(4.5);
            $table->unsignedInteger('rating_count')->default(0);
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'limited'])->default('in_stock');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_deal')->default(false);
            $table->boolean('is_gift_card')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
