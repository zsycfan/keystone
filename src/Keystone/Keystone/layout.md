Layout
====

A layout is similar to a "content type" or "channel" in traditional
blogging systems. Layouts setup a UI for a specific format of data,
whether it's a blog or a biography.


parentPage
----

Regions will commonly be nested within a page. This property provides
access into that page.

Returns the parent `Page` or `null` if the region is orphaned.

```php
$region = \Keystone\Region::makeWithName('body');
$region->parentPage
```