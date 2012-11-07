<?php

class Keystone_Create_Asset_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assets', function($table) {
      $table->increments('id');
      $table->string('path', 1024);
      $table->string('name', 512);
      $table->string('type', 255);
      $table->string('mime', 255);
      $table->integer('width');
      $table->integer('height');
      $table->integer('filesize');
      $table->string('caption', 512);
      $table->string('credit', 512);
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
		Schema::drop('assets');
	}

}