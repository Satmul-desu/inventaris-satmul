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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->string('borrower_name'); // Nama peminjam
            $table->string('borrower_phone')->nullable(); // No HP peminjam
            $table->integer('qty'); // Jumlah barang yang dipinjam
            $table->date('borrow_date'); // Tanggal pinjam
            $table->date('return_date'); // Tanggal harus kembali
            $table->date('actual_return_date')->nullable(); // Tanggal kembali sebenarnya
            $table->enum('status', ['pending', 'borrowed', 'returned', 'overdue', 'lost'])->default('pending');
            $table->text('note')->nullable(); // Catatan
            $table->text('return_note')->nullable(); // Catatan saat pengembalian
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang memproses
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};

