<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_pedimento');
            $table->foreign("id_pedimento")
                    ->references("id")
                    ->on("pedimentos");
            $table->string("IDItem");
            $table->string("Nombre");
            $table->string("Sku");
            $table->integer("Cantidad");
            $table->string("No_Serie");
            $table->string("Pedimento");
            $table->date("FechaPedimento");
            $table->string("Aduana");
            $table->boolean("status");
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
        Schema::dropIfExists('items');
    }
}
