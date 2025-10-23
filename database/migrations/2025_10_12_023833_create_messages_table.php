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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // Optional property link (nullable so general chat also works)
            $table->foreignId('property_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            // Sender of the message
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Receiver of the message
            $table->foreignId('receiver_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Message text
            $table->text('content');

            // Track whether message has been read
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
