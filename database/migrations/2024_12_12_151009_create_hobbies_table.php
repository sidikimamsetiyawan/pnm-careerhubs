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
        if (!Schema::hasTable('hobbies')) {
            Schema::create('hobbies', function (Blueprint $table) {
                $table->id(); // Primary key
                $table->string('hobby_name'); // Nama hobi
                $table->timestamps(); // Kolom created_at dan updated_at
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hobbies');
    }
};
