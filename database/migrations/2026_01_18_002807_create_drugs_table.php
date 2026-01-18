<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name', 255);
            $table->integer('content_quantity'); // 10, 20, 30 etc.
            $table->string('content_unit'); // caps, ml, mg, etc.
            $table->string('strength', 100); // 500mg, 250mg/5ml etc.
            $table->boolean('is_compounded')->default(false);
            $table->string('route_of_administration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
