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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id(); // Unique Visitor ID
            $table->string('fullname');
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('email')->unique()->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->integer('jailer_id')->nullable();
            $table->date('date')->nullable();

            // KYC Fields (Visitors complete KYC later)
            $table->string('aadhar_number')->unique()->nullable();
            $table->string('voter_id')->unique()->nullable();
            $table->string('aadhar_proof')->nullable();
            $table->string('voter_proof')->nullable();
            $table->enum('kyc_status', ['Pending', 'Update KYC', 'Approved', 'Rejected'])->default('Pending');
            $table->date('kyc_update_date')->nullable();
            $table->longText('reason_kyc_rejected')->nullable();
            $table->char('status', 1)->comment('1:active, 2:de-active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
