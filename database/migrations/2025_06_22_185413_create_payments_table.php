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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("card_id");
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('card_id')->references('id')->on('cards');
            $table->enum("payment_method",["COD","visa"]);
            $table->enum("status",["paid", "failed", "pending"]);
            $table->timestamp("paid_at")->nullable();
            $table->string("transaction_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
