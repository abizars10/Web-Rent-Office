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
        Schema::create('office_spaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('thumbnail');
            $table->string('address');
            $table->boolean('is_open');
            $table->boolean('is_full_booked');
            $table->unsignedInteger('price'); // Value atau angka tidak boleh negatif
            $table->unsignedInteger('duration');
            $table->text('about');
            $table->foreignId('city_id')->constrained()->cascadeOnDelete(); // Relasi dari table cities
            $table->string('slug')->unique();
            $table->softDeletes(); // Membuat deleteAt, menghapus data di fe namun masih tersimpan di be
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_spaces');
    }
};
