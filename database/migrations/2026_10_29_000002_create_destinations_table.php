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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('badge_label')->nullable();
            $table->text('description');
            $table->string('location');
            $table->string('subdistrict')->nullable();
            $table->text('address_full')->nullable();
            $table->integer('price')->default(0);
            $table->decimal('rating', 3, 1)->default(4.8);
            $table->integer('reviews_count')->default(0);
            $table->text('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('facilities')->nullable();
            $table->json('highlights')->nullable();
            $table->string('type')->default('ticket');
            $table->string('price_label')->default('/ orang');
            $table->string('price_type_title')->default('TIKET MASUK');
            $table->string('button_label')->default('Lihat Detail >');
            $table->string('button_class')->default('btn-slate-soft');
            $table->boolean('is_featured')->default(false);
            $table->string('open_hours')->default('07:00 - 17:00 WIB');
            $table->string('temperature')->default('20° - 23° C');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
