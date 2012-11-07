<?php

class Keystone_Create_Page_Tables {

  /**
   * Make changes to the database.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pages', function($table) {
      $table->increments('id');
      $table->timestamps();
    });
    Schema::create('page_revisions', function($table) {
      $table->increments('id');
      $table->integer('page_id');
      $table->string('language', 32)->default('en-us');
      $table->string('path', 1024);
      $table->string('slug', 255);
      $table->string('layout', 255);
      $table->string('title', 255);
      $table->text('excerpt');
      $table->text('regions');
      $table->date('published_at');
      $table->boolean('published')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Revert the changes to the database.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('pages');
    Schema::drop('page_revisions');
  }

}