<?php

use Illuminate\Database\Migrations\Migration;

class CreateUriTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
  {
    Schema::create('content_uris', function($table)
    {
      $table->increments('id');
      $table->integer('content_id')->references('id')->on('contents');
      $table->string('uri');
      $table->string('segment0')->nullable()->default(null);
      $table->string('segment1')->nullable()->default(null);
      $table->string('segment2')->nullable()->default(null);
      $table->string('segment3')->nullable()->default(null);
      $table->string('segment4')->nullable()->default(null);
      $table->string('segment5')->nullable()->default(null);
      $table->string('segment6')->nullable()->default(null);
      $table->string('segment7')->nullable()->default(null);
      $table->string('segment8')->nullable()->default(null);
      $table->string('segment9')->nullable()->default(null);
      $table->string('segment10')->nullable()->default(null);
      $table->string('segment11')->nullable()->default(null);
      $table->string('segment12')->nullable()->default(null);
      $table->string('segment13')->nullable()->default(null);
      $table->string('segment14')->nullable()->default(null);
      $table->string('segment15')->nullable()->default(null);
      $table->string('segment16')->nullable()->default(null);
      $table->string('segment17')->nullable()->default(null);
      $table->string('segment18')->nullable()->default(null);
      $table->string('segment19')->nullable()->default(null);
      $table->string('segment20')->nullable()->default(null);
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
    Schema::drop('content_uris');
  }

}