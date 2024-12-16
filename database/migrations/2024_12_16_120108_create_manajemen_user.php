<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //create table profile
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_awal');
            $table->string('nama_akhir');
            $table->string('nama_lengkap')->virtualAs('concat(nama_awal, \' \', nama_akhir)');
            $table->text('alamat');
            $table->string('kontak');
            $table->timestamps();
        });

        //create foreign_key for user profile
        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid('profile_id')->nullable()->constrained('profiles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('profile_id');
            $table->dropColumn(['profile_id']);
        });

        Schema::dropIfExists('profiles'); 
    }
};
