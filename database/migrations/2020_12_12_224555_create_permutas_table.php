<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permutas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained('imoveis');
            $table->foreignId('tipo_id')->constrained('tipos');
            $table->foreignId('subtipo_id')->constrained('subtipos');
            $table->foreignId('range_id')->constrained('ranges');
            $table->enum('status', [ "ativo" , "inativo" ])->default("ativo");
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
        Schema::dropIfExists('permutas');
    }
}
