# Lascaux

With next to zero configuration Lascaux allows you to write complex queries without worrying about things like associations or framework specific method names. Just write SQL and let Lascaux do the rest.

A few examples, given a traditional blogging platform where authors write posts and users comment on them:

```php
<?php
/**
 * Load objects out of the database.
 */
function getIndex() {
  return View::make(array(
    'posts' => Post::all(),
  ));
}

/**
 * Easily find an object by index.
 */
function getShow($id) {
  return View::make(array(
    'post' => Post::find($id),
  ));
}

/**
 * Even query the database against an instantiated model object.
 */
function getAuthorArchive(Author $author) {
  return View::make(array(
    'author' => $author,
    'post' => Post::where('author', '=', $author)->get(),
  ));
}

/**
 * Write complex logic and forget about()->dealing()->with()->all()->that().
 *
 * In this example we pull all published posts by an author, unless the author
 * is the logged in user, in which case we'll pull all posts.
 */
function getAuthorArchive(Author $author) {
  return View::make(array(
    'tag' => $tag,
    'post' => Post::predicate('(author = ? AND (published = 1 OR author = ?))', Author::first(), Auth::user())->get(),
  ));
}

/**
 * Save data to the database by instantiating models
 */
function postAuthor() {
  $author = new Author;
  $author->name = Input::get('author.name');
  $author->birthday = Input::get('author.birthday');
  $author->save();

  return Redirect::route('edit_author', $author->pk());
}

/**
 * If you're a fan of chaining methods, go crazy you silly goose.
 * Seriously though, don't do this it's just plain illegible.
 */
function putAuthor(Author $author) {
  return Redirect::route('edit_author', $author->setBioAttribute(Input::get('author.bio'))->save()->pk());
}

/**
 * Query and join nested relationships with ease.
 */
function getPosts() {
  return View::make(array(
    'posts' => Post::with('comments', 'comments.author')->get(),
  ));
}