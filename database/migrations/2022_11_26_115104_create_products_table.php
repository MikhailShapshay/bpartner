<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('category_id'); // родительская категория
                $table->string('title'); // наименование
                $table->text('description'); // описание
                $table->decimal('cost'); // цена
                $table->string('slug'); // slug
                $table->timestamps();
                $table->foreign('category_id')
                    ->references('id')
                    ->on('categorys')
                    ->onUpdate('cascade')
                    ->onDelete('cascade'); // каскадный ключ
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('products')) {
            Schema::dropIfExists('products');
        }
    }
}
