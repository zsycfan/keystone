Layout
====

Initialization

* [:makeNamed](#makeNamedstring-name)

Properties

* [:name](#name)

Managing Regions

* [:addRegion](#addRegionRegion-region)
* [:region](#regionstring-name)

---

:makeNamed(string $name)
----

Creates a new layout with the specified name. The name will later be used to map to a directory on the disk containing the layout markup. Therefore, the name should be URL and file system safe.

```php
$layout = \Keystone\Layout::makeNamed('landing');
```

The Layout may be one of the most important classes in Keystone because it proxies data between the regions and the browser. Through this class you have the ability to render a back-end editing interface as well as a front-end view. A `Page` in Keystone actually doesn't have any native data associated with it, the data is attached to the page's layout.

:addRegion(Region $region)
----
Adds a `Keystone\Region` to the layout. Once added, the region will become available to the layout during a `form` or `markup` rendering.

```php
$region = \Keystone\Region::makeNamed('body');
$layout = \Keystone\Layout::makeNamed('landing');
$layout->addRegion($region);
```

:region(string $name)
----

Get a region, by name, from this layout. The way Keystone works, Regions are cheap objects. They can be created and destroyed rather effortlessly. A developer could add a new region into their layout by simply adding `<? region('body') ?>`. Likewise, they could destroy a region by removing that line. Because of this `:region` will always return a Region object even if a matching name has not been added with `:addRegion`.

```php
$layout = \Keystone\Layout::makeNamed('landing')->addRegion(\Keystone\Region::makeNamed('body'));
$layout->region('body');    // returns the previously added region
$layout->region('sidebar'); // returns a new region, named 'sidebar'
```

:name()
----

Returns the name of this layout.

:form()
----

Renders an editable, back-end, view of the layout.

:markup()
----

Renders the front-end view of the layout.
