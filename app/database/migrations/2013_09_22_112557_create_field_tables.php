<?php

use Illuminate\Database\Migrations\Migration;

class CreateFieldTables extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('element_fields', function($table)
    {
      $table->increments('id');
      $table->integer('element_id')->references('id')->on('elements');
      $table->string('type');
      $table->string('name');
      $table->string('slug');
      $table->integer('order')->default(0);
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
    Schema::drop('element_fields');
  }

}