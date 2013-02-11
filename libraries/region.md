Region
====

Regions are the editable areas within a layout. They can be
configured to have one or more fields representing the field data
of a region.

----


makeWithName($name)
----

Creates a new region specified by the passed name
parameter. Regions are always referred to by name and never
by an index or other identifier.

```php
$region = \Keystone\Region::makeWithName('body');
```


name
----

Returns the string name of the region. This property can not be set
except for during initalization within the `makeWithName` static method.

```php
$region = \Keystone\Region::makeWithName('body');
$region->name // returns "body"
```


parentLayout
----

Regions will commonly be nested within a layout. This property provides
access to that layout.

Returns the parent `Layout` or `null` if the region is orphaned.

```php
$layout = \Keystone\Layout::makeWithName('subpage');
$layout->addRegion(\Keystone\Region::makeWithName('body'));
$layout->getRegion('body')->parentLayout // same as $layout
```


parentPage
----

Regions will commonly be nested within a page. This property provides
access to that page.

Returns the parent `Page` or `null` if the region is orphaned.

```php
$region = \Keystone\Region::makeWithName('body');
$region->parentPage
```


max
----

Configures the maximum number of fields this region 
may contain. This setting only affects new fields, if it
is updated and existing regions exceed the max their content
will remain as is, yet uneditable, until the number of
fields is reduced.

This field additionallh controls the presence of the Add Field
button within the UI. If the number of fields meets or
exceeds the max, the add field button will be hidden.

```php
\Keystone\Region::makeWithName('body')->max = 3;
```