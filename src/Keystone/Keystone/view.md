View
====

Registration

* [:addHandler](#addHandlerstring-extension-string-className)
* [:add*Directory]()

Initialization

* [:make*](#makeNamedstring-name)

Properties

* [:data](#name)

---

:addHandler(string $extension, string $className)
----

Registers a handler for use with the rendering engine. The extension 

```php
\Keystone\View::addHandler('landing');
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
