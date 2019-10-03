<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('sha');
            $table->string('sha_global');
            $table->string('name');
            $table->string('url');
            $table->string('price');
            $table->integer('price_main');
            $table->integer('price_rest');
            $table->string('currency', 5);
            $table->string('picture');
            $table->string('delivery');
            $table->text('description');
            $table->timestamps();

            $table->index('sha', 'idx-items-sha');
            $table->index('sha_global', 'idx-items-sha_global');
            $table->index('name', 'idx-items-name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropIndex('idx-items-name');
            $table->dropIndex('idx-items-sha_global');
            $table->dropIndex('idx-items-sha');
        });

        Schema::dropIfExists('items');
    }
}
