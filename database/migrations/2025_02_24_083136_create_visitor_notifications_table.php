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
        Schema::create('visitor_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_id');
            $table->longText('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('time_date')->nullable();
            $table->char('show_in_dashboard', 1)->comment('0:no, 1:yes')->default(0);
            $table->char('mark_read', 1)->comment('0:no-read, 1:read')->default(0);
            $table->char('status')->comment('1:active, 2:de-active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_notifications');
    }
};
