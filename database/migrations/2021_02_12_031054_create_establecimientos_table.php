<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablecimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function(Blueprint $table){
            $table->id();
            $table->string('nombre',70);
            $table->string('slug',75);
            $table->timestamps();
        });

        Schema::create('establecimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('nombre',80);            
            $table->string('img_principal');
            $table->string('direccion');
            $table->string('colonia');
            $table->string('lat',30);
            $table->string('lng',30);
            $table->string('telefono',20);
            $table->string('descripcion');
            $table->time('apertura');
            $table->time('cierre');
            $table->uuid('uuid');
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
        Schema::dropIfExists('establecimientos');
        Schema::dropIfExists('categorias');
        
    }
}
