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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->integer('visitor_id');
            $table->string('fullname');
            $table->string('phone')->unique();
            $table->string('email')->unique()->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('aadhar_number')->unique();
            $table->string('voter_id')->unique();
            $table->string('aadhar_proof')->nullable();
            $table->string('voter_proof')->nullable();
            $table->enum('kyc_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('reason_kyc_rejected')->nullable();
            $table->date('registered_at')->nullable();
            $table->date('kyc_approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
