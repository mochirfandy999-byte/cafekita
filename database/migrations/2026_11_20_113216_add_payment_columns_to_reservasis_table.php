<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable();
            $table->integer('total_bayar')->default(0);
            $table->integer('uang_dibayar')->default(0);
            $table->integer('kembalian')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'total_bayar', 'uang_dibayar', 'kembalian']);
        }); 
    }
};
