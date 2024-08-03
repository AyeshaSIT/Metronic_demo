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
        Schema::create('jobs_processed', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audiocall_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('status')->default(1);
            $table->timestamp('starttime')->nullable(); 
            $table->timestamp('endtime')->nullable(); 
            $table->integer('duration')->nullable(); 
            $table->integer('retries')->default(0);
            $table->timestamps();
            $table->foreign('audiocall_id')->references('id')->on('audiocalls')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                        
                    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs_processed');
    }
};
