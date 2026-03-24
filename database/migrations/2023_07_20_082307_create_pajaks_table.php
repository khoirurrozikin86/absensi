<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePajaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pajaks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('status_id')->constrained('status_ptkps')->onDelete('cascade');
            $table->foreignId('payroll_id')->constrained('payrolls')->onDelete('cascade');

            $table->string('bulan');
            $table->string('tahun');

            // hasil hitungan pajak
            $table->bigInteger('penghasilan_bruto')->nullable();
            $table->bigInteger('pengurangan')->nullable();  // BPJS + mangkir + telat
            $table->bigInteger('penghasilan_netto_bulan')->nullable();
            $table->bigInteger('penghasilan_netto_tahun')->nullable();
            $table->bigInteger('ptkp')->nullable();
            $table->bigInteger('pkp')->nullable();
            $table->bigInteger('pph21_setahun')->nullable();
            $table->bigInteger('pph21_perbulan')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pajaks');
    }
}
