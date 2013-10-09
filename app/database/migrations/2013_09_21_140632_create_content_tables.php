<?php

use Illuminate\Database\Migrations\Migration;

class CreateContentTables extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('contents', function($table)
    {
        $table->increments('id');
        $table->integer('content_type_id')
          ->references('id')
          ->on('content_types')
          ->onDelete('cascade');
        $table->string('lang')
          ->nullable()
          ->default(null);
        $table->boolean('published')->default(0);
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
    Schema::drop('contents');
  }

}