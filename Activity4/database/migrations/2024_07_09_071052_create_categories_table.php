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
        Schema::create('categories', function (Blueprint $table) {
            $table->id('categoryID');
            $table->string('categoryName');
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table){
            $table->unsignedBigInteger('categoryID')->nullable();
            $table->foreign('categoryID')->references('categoryID')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function(Blueprint $table){
            $table->dropForeign(['categoryID']);
            $table->dropColumn(['categoryID']);
        });
        
        Schema::dropIfExists('categories');
    }
};
