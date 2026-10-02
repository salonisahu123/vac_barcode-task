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
        // create_tickets_table.php
Schema::create('tickets', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('user_id');

    $table->string('title');
    $table->string('subject');
    $table->longText('description')->nullable();

    $table->enum('ticket_type', ['individual', 'location']);

    $table->unsignedBigInteger('location_id')->nullable();
    $table->unsignedBigInteger('department_id')->nullable();

    $table->enum('priority', ['low', 'medium', 'high'])->default('low');

    $table->string('attachment')->nullable();

    $table->enum('status', [
        'pending',
        'assigned',
        'in_progress',
        'hold',
        'close_request',
        'closed',
        'reopen'
    ])->default('pending');

    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
