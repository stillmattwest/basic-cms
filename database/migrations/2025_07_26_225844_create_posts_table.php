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
        Schema::create('posts', function (Blueprint $table) {
            // Primary key and timestamps
            $table->id();
            $table->timestamps();

            // Basic content
            $table->string('title'); 
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->text('excerpt')->nullable();

            // Metadata
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable(); 
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();

            // Status and visibility
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false);

            // Relationships
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
