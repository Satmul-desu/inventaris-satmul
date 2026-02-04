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
        // Sandbox table untuk Q&A/Diskusi
        Schema::create('sandbox', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->string('subject')->nullable(); // Topik pertanyaan
            $table->text('message'); // Isi pesan/pertanyaan
            $table->enum('type', ['question', 'answer', 'announcement'])->default('question');
            $table->enum('priority', ['low', 'normal', 'high'])->default('normal');
            $table->enum('status', ['open', 'answered', 'closed'])->default('open');
            $table->foreignId('parent_id')->nullable()->constrained('sandbox')->onDelete('cascade'); // Untuk reply/thread
            $table->boolean('is_pinned')->default(false); // Untuk notifikasi penting
            $table->timestamps();
        });

        // Update notifications table untuk lebih lengkap
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('sender_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title')->nullable()->after('type'); // Judul notifikasi
            $table->enum('priority', ['low', 'normal', 'high'])->default('normal')->after('is_read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['sender_id', 'user_id', 'title', 'priority']);
        });
        Schema::dropIfExists('sandbox');
    }
};

