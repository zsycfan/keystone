<?php

use Illuminate\Database\Migrations\Migration;

class CreateContentTypesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('content_types', function($table)
    {
        $table->increments('id');
        $table->boolean('single')->default(0);
        $table->string('name');
        $table->string('slug');
        $table->integer('rows')->default(1);
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
    Schema::drop('content_types');
  }

}