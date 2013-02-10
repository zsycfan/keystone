Plugin
====

The plugin class handles starting and registering plugins with their 
default naming schemes.


Start
----

Loops through all registered plugin directories and either:

1. Includes the `start.php` file for each plugin.
2. If the start file can not be loaded it calls `register` with the
directory name of each plugin.

```php
Keystone\Plugin::start()
```


Register
----

Passed the name of a plugin this method will register the appropriate sub
classes determined by the existance of specially named files. For example,
if a `Field` is defined in `libraries/field` it will be registered with
the `Keystone\Field` class.

```php
Keystone\Plugin::register('tags')
```