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
      $table->string('layout', 255)->nullable();
      $table->string('title', 255)->nullable();
      $table->text('excerpt')->nullable();
      $table->text('regions')->nullable();
      $table->timestamps();
      $table->index('page_id');
    });
    Schema::create('page_paths', function($table) {
      $table->increments('id');
      $table->integer('revision_id');
      $table->integer('order')->nullable();
      for ($i=1; $i<=20; $i++) {
        $table->string("segment{$i}", 255)->nullable();
      }
      $table->timestamps();
      $table->index('revision_id');
    });
    Schema::create('page_publishes', function($table) {
      $table->integer('page_id');
      $table->integer('revision_id');
      $table->date('published_at');
      $table->index('page_id');
      $table->unique('revision_id');
      $table->unique(array('page_id', 'revision_id'));
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
    Schema::drop('page_paths');
    Schema::drop('page_publishes');
  }

}