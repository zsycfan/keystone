<?php

use Illuminate\Database\Migrations\Migration;

class CreateElementsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('elements', function($table)
    {
        $table->increments('id');
        $table->string('name');
        $table->string('slug');
        $table->timestamps();
    });

    Schema::create('content_elements', function($table)
    {
        $table->increments('id');
        $table->integer('content_id');
        $table->integer('region_id');
        $table->integer('element_id');
        $table->integer('element_order');
        $table->timestamps();
    });

    Schema::create('content_element_revisions', function($table)
    {
        $table->increments('id');
        $table->integer('content_element_id');
        $table->boolean('published');
        $table->string('lang');
        $table->timestamps();
    });

    Schema::create('content_element_revision_values', function($table)
    {
        $table->increments('id');
        $table->integer('revision_id');
        $table->integer('field_id');
        $table->string('value');
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
    Schema::drop('elements');
    Schema::drop('content_elements');
    Schema::drop('content_element_revisions');
    Schema::drop('content_element_revision_values');
  }

}