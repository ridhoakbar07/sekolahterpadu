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
        //create table pos terima
        Schema::create('pos_masuks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_pos');
            $table->decimal('biaya', total: 20, places: 2);
            $table->enum('skema_pembayaran', ['Bulanan', 'Tahunan', 'Sekali']);
            $table->foreignUuid('unit_id')->nullable()->constrained('units');
            $table->timestamps();
        });

        //create table pos terima
        Schema::create('pos_keluars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_pos');
            $table->decimal('biaya', total: 20, places: 2);
            $table->timestamps();
        });

        //create table tagihan
        Schema::create('tagihans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('batas_bayar');
            $table->string('nama_tagihan');
            $table->string('jumlah');
            $table->foreignUuid('siswa_id')->constrained('siswas');
            $table->foreignUuid('kelas_id')->constrained('kelas');
            $table->timestamps();
        });

        //create table kas masuk
        Schema::create('kas_masuks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_transaksi')->virtualAs("CONCAT('TKM-',DATE_FORMAT(created_at,'%y%m%d%s%i%k'))");
            $table->date('tanggal');
            $table->text('keterangan');
            $table->decimal('total', total: 20, places: 2);
            $table->foreignUuid('siswa_id')->nullable()->constrained('siswas');
            $table->timestamps();
        });

        //create table detail kas masuk
        Schema::create('detail_kas_masuks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('jumlah', total: 20, places: 2);
            $table->text('keterangan')->nullable();
            $table->foreignUuid('kas_masuk_id')->constrained('kas_masuks')->onDelete('cascade');
            $table->foreignUuid('tagihan_id')->constrained('tagihans');
            $table->timestamps();
        });

        //create table kas keluar
        Schema::create('kas_keluars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_transaksi')->virtualAs("CONCAT('TKK-',DATE_FORMAT(created_at,'%y%m%d%s%i%k'))");
            $table->date('tanggal');
            $table->text('keterangan');
            $table->decimal('total', total: 20, places: 2);
            $table->string('attachment', 255)->nullable();
            $table->foreignId('admin_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_masuks');
        Schema::dropIfExists('pos_keluars');
        Schema::dropIfExists('detail_kas_masuks');
        Schema::dropIfExists('kas_masuks');
        Schema::dropIfExists('tagihans');
        Schema::dropIfExists('kas_keluars');
    }
};
