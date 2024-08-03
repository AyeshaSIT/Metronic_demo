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
        Schema::create('call_user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('type')->default(1);
            // $table->enum('type', ['customer', 'agent']);
            $table->string('avatar')->nullable();
            // $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_user');
    }
};
