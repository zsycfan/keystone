Layout Manager
====

Like most `Manager` classes in Keystone the Layout Manager stores and reports
on the available layouts.


::register($type, $path)
----

Registers a layout with the system.

```php
Keystone\LayoutManager::register('subpage.content', '/path/to/content.php');
```


::getNamed($name)
----

Returns the path to the layout. If a layout view is not specificed it will
default to the `content` view.

```php
Keystone\LayoutManager::getNamed('subpage.content');
```


::all()
----

Returns all of the registered layouts.

```php
Keystone\LayoutManager::all();
```