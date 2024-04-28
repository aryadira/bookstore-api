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
        Schema::create('rent_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rent_id')->nullable(false);
            $table->unsignedBigInteger('book_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->date('rent_return')->nullable();
            $table->timestamps();

            $table->foreign('rent_id')->on('rents')->references('id');
            $table->foreign('book_id')->on('books')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_returns');
    }
};
