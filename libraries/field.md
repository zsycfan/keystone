Field
====

The field object represents smallest divisible piece of content within
Keystone. Fields are assembled into regions which are contained within
layouts that eventually get rendered to a page. It is the `Field` that
does most of the work with the database and the content of the site.


parentLayout
----

Fields will commonly be nested within a layout. This property provides
access to that layout.

Returns the parent `Layout` or `null` if the field is orphaned.

```php
$field = \Keystone\Field::makeWithType('tags');
$field->parentLayout
```


parentPage
----

Fields will commonly be nested within a page. This property provides
access to that page.

Returns the parent `Page` or `null` if the field is orphaned.

```php
$field = \Keystone\Field::makeWithType('tags');
$field->parentPage
```


parentRegion
----

Fields will commonly be nested within a page. This property provides
access to that page.

Returns the parent `Page` or `null` if the field is orphaned.

```php
$field = \Keystone\Field::makeWithType('tags');
$field->parentRegion
```


Set Data
----

Setting the data of a field can happen in many different ways. We
could be pulling the data out of a data repository (the database)
or parsing user input throuth the POST. Because of this the Field
object provides named methods for each. They are:

* setDataFromDatabase
* setDataFromPost