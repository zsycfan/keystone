<?php

require_once 'tests/models/Post.php';
require_once 'tests/models/Comment.php';
require_once 'tests/models/Author.php';
require_once 'tests/models/Avatar.php';

class SelectTest extends PHPUnit_Framework_TestCase {

  public function testSelect()
  {
    $this->assertEquals('mark', Post::predicate('author = ?', Author::first())->first()->author->name);
    $this->assertEquals('mark.jpg', Post::with('author.avatar')->predicate('author = ?', Author::first())->first()->author->avatar[0]->url);
    $this->assertEquals(2, Author::with('posts')->where('name', '=', 'mark')->first()->posts->count());
    $this->assertEquals('mark', Post::with('comments', 'comments.author')->first()->comments[0]->author->name);
    $this->assertEquals('mark2.jpg', Post::with('comments', 'comments.author', 'comments.author.avatar')->first()->comments[0]->author->avatar[1]->url);
    $this->assertEquals('john', Post::with('comments', 'comments.author')->first()->comments[1]->author->name);
    $this->assertEquals('john.jpg', Post::with('comments', 'comments.author', 'comments.author.avatar')->first()->comments[1]->author->avatar[0]->url);
  }

}