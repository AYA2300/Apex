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
            $table->string('email')->unique()->nullable();
            $table->string('role')->default('user');
            $table->string('phone_number')->unique()->nullable();
            $table->string('university_number')->nullable();
            $table->string('verification_code')->default(null)->nullable();
            $table->string('password');
            $table->string('confirm_password');
            $table->string('image')->nullable();
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->enum('academic_year',['1','2','3','4','5'])->nullable();
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
