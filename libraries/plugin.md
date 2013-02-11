Plugin
====

The plugin class handles starting and registering plugins with their 
default naming schemes.


::start()
----

Loops through all registered plugin directories and either:

1. Includes the `start.php` file for each plugin.
2. If the start file can not be loaded it calls `register` with the
directory name of each plugin.

```php
Keystone\Plugin::start()
```


::register()
----

Passed the name of a plugin this method will register the appropriate sub
classes determined by the existance of conventionally named files.

```php
Keystone\Plugin::register('tags')
```

When called it looks for the following:

* `libraries/field.php` to define a `TagsField` class which will respond
to sleep and wakeup events.
* `css/field.css` for display of the field UI
* `javascript/field.js` for display of the field UI
* `views` folder, used to render `views/field.twig` in the field UI
* `layouts` folder, which contains one or more layouts provided by the
plugin