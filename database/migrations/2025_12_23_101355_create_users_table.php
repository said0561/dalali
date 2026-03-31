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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone')->unique(); 
        $table->string('email')->nullable()->unique();
        $table->string('password');
        
        // Hapa sasa tunatumia Role ID badala ya Enum
        $table->foreignId('role_id')->constrained()->onDelete('cascade');
        
        $table->foreignId('region_id')->nullable()->constrained()->onDelete('set null');
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
