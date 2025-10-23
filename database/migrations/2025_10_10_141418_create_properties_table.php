<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('address');
            $table->decimal('price', 10, 2);
            $table->integer('capacity')->default(1);
            $table->double('latitude', 10, 7)->nullable();
            $table->double('longitude', 10, 7)->nullable();
            $table->json('amenities')->nullable();
            $table->enum('status', ['available','full','partial'])->default('available');
            $table->boolean('is_verified')->default(false);
            $table->text('rules')->nullable();
            $table->integer('available_rooms')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
