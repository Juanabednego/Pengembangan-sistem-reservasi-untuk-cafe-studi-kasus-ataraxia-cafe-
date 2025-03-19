<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('payment_method');
            $table->string('proof_of_payment');
            $table->enum('status', ['pending', 'waiting_confirmation', 'confirmed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
