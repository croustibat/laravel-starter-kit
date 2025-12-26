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
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digest_id')->constrained()->cascadeOnDelete();
            $table->enum('platform', ['linkedin', 'twitter']);
            $table->enum('status', ['pending', 'published', 'failed'])->default('pending');
            $table->string('post_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }
};
