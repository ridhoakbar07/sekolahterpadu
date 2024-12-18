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
        //create table yayasan
        Schema::create('yayasans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->date('tanggal_pendirian')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('email')->nullable();
            $table->text('visi_misi')->nullable();
            $table->string('no_status_hukum')->nullable();
            $table->string('ketua_yayasan')->nullable();
            $table->timestamps();
        });

        //create table sekolah
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->text('alamat');
            $table->string('telp');
            $table->string('email');
            $table->enum('jenis', ['Utama', 'Cabang']);
            $table->foreignUuid('yayasan_id')->constrained('yayasans');
            $table->timestamps();
        });

        //create table unit
        Schema::create('units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('nama_unit', ['Paud', 'SD', 'SMP', 'SMA']);
            $table->foreignUuid('sekolah_id')->nullable()->constrained('sekolahs');
            $table->timestamps();
        });

        //create table kelas
        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_kelas');
            $table->enum('jenis', ['Umum', 'Pondok', 'Fullday'])->nullable();
            $table->foreignUuid('unit_id')->constrained('units');
            $table->timestamps();
        });

        //create table siswa
        Schema::create('siswas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('NISN');
            $table->string('nama');
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->foreignId('ortu_id')->nullable()->constrained('users');
            $table->timestamps();
        });

        //create associate table siswa -> kelas
        Schema::create('siswa_kelas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('periode');
            $table->boolean('isAktif');
            $table->foreignUuid('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignUuid('kelas_id')->constrained('kelas');
            $table->timestamps();
        });

        Schema::create('admin_sekolahs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignUuid('sekolah_id')->constrained('sekolahs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['ortu_id']);
            $table->dropColumn(['ortu_id']);
        });

        Schema::dropIfExists('admin_sekolahs');
        Schema::dropIfExists('siswa_kelas');
        Schema::dropIfExists('siswas');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('units');
        Schema::dropIfExists('sekolahs');
        Schema::dropIfExists('yayasans');
    }
};
