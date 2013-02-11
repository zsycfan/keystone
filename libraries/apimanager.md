Api Manager
====

Like most `Manager` classes in Keystone the Api Manager stores and reports
on the available API classes.


::register($name, $class)
----

Registers an API with the system.

```php
Keystone\ApiManager::register('tags', '\MyCustomNamespace\TagApi');
```


::getNamed($name)
----

Returns the class of the registered API or false on failure.

```php
Keystone\FieldManager::getNamed('tags');
```


::all()
----

Returns all of the registered field types.

```php
Keystone\FieldManager::all();
```