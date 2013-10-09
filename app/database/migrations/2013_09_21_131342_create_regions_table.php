<?php

use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('regions', function($table)
    {
        $table->increments('id');
        $table->integer('content_type_id');
        $table->string('name');
        $table->string('slug');
        $table->integer('row');
        $table->integer('column_width');
        $table->integer('column_offset')->default(0);
        $table->integer('column_order');
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
    Schema::drop('regions');
  }

}