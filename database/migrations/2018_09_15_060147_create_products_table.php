<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',8)->unique();
            $table->string('name');
            $table->string('address');
            $table->string('mobile');
            $table->string('cp')->nullable();
            $table->string('rekening')->nullable();
            $table->string('npwp')->nullable();
            $table->timestamps();
        });

        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',8);
            $table->date('tanggal');
            $table->integer('stockIn')->default(0);
            $table->integer('stockOut')->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',8)->unique();
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->decimal('harga_pokok',10,2)->default(0);
            $table->decimal('harga_beli',10,2)->default(0);
            $table->decimal('harga_jual',10,2)->default(0);
            $table->integer('supplier_id')->unsigned();
            $table->decimal('perInPrice',10,2)->default(0);
            $table->decimal('diskonPer',10,2)->default(0);
            $table->decimal('diskonNom',10,2)->default(0);
            $table->integer('diskonUnit')->default(0);
            $table->date('batasDiskon');
            $table->decimal('nStokBeli',10,2)->default(0);
            $table->decimal('nStokJual',10,2)->default(0);
            $table->integer('minStok')->default(0);
            $table->integer('stok')->default(0);
            $table->integer('stokAwal')->default(0);
            $table->string('kemasan')->nullable();
            $table->text('komposisi')->nullable();
            $table->boolean('resepdokter')->default(false);
            $table->boolean('narkotika')->default(false);
            $table->string('produsen')->nullable();
            $table->text('gambar')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('unit_id')
                ->references('id')->on('units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('supplier_id')
                ->references('id')->on('suppliers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('cards');
        Schema::dropIfExists('products');
    }
}
