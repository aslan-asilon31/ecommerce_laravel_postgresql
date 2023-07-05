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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prod_transactions_id')->nullable();
            $table->string('barcode');
            $table->string('invoice_code');
            $table->string('cust_name');
            $table->string('cust_email');
            $table->string('cust_phone');
            $table->text('cust_address');
            $table->string('cust_type');
            $table->integer('total_price');
            $table->string('payment_method');
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
