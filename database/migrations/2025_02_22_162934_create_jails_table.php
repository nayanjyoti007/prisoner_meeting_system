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
        Schema::create('jails', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Jail name
            $table->integer('district_id');
            $table->enum('type', ['Central', 'District', 'Special', 'Open Air', 'Sub-Jail']); // Jail type
            $table->integer('total_rooms')->default(0); // Number of meeting rooms
            $table->char('status', 1)->comment('1:active, 2:de-active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jails');
    }
};
