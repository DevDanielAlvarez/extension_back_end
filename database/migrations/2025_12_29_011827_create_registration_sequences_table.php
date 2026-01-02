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
        /*
        This table is used to generate unique registration numbers for users.
        */
        Schema::create('registration_sequences', function (Blueprint $table) {
            $table->id();
            $table->char('letter', 1)->unique();
            $table->unsignedInteger('current_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_sequences');
    }
};
