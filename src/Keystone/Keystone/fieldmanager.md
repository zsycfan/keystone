Field Manager
====

Like most `Manager` classes in Keystone the Field Manager stores and reports
on the available fields.


::register($type, $class)
----

Registers a field type with the system.

```php
Keystone\FieldManager::register('tags', '\MyCustomNamespace\TagField');
```


::getClassOfType($type)
----

Returns the class of the registered field type or false on failure.

```php
Keystone\FieldManager::getClassOfType('tags');
```


::all()
----

Returns all of the registered field types.

```php
Keystone\FieldManager::all();
```