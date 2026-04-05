<?php

use App\Enums\RechargeRequestStatus;
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
        Schema::create('recharge_requests', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->string('number');
            $table->decimal('amount', 10, 2);
            $table->string('sender_name');
            $table->string('screenshot_path');
            $table->string('transcode');
            $table->foreignUlid('approved_by')->nullable()->constrained('managers')->nullOnDelete();
            $table->string('payment_method');
            $table->foreignId('payment_method_id')->nullable()->constrained()->cascadeOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->enum('status', RechargeRequestStatus::toArray())
                ->default(RechargeRequestStatus::Pending->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recharge_requests');
    }
};
