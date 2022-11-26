<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('categorys')) {
            Schema::create('categorys', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('parent_id'); // родительская категория
                $table->string('title'); // наименование
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
        if (Schema::hasTable('categorys')) {
            Schema::dropIfExists('categorys');
        }
    }
}
