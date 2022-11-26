<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('propertys')) {
            Schema::create('propertys', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_id'); // родительский товар
                $table->string('title'); // наименование свойства
                $table->string('value'); // значение свойства
                $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onUpdate('cascade')
                    ->onDelete('cascade'); // каскадный ключ
                $table->timestamps();
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
        if (Schema::hasTable('propertys')) {
            Schema::dropIfExists('propertys');
        }
    }
}
