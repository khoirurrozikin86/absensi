<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifPphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif_pphs', function (Blueprint $table) {
            $table->id();
            $table->decimal('batas_bawah', 15, 2)->default(0); // mulai penghasilan sekian
            $table->decimal('batas_atas', 15, 2)->nullable();  // sampai penghasilan sekian (null = tak terbatas)
            $table->decimal('tarif', 5, 2);                    // persen, contoh 5.00
            $table->year('year')->default(date('Y'));
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
        Schema::dropIfExists('tarif_pphs');
    }
}
