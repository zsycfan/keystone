Asset
====

The `Asset` class accepts any number of static files which will later be
rendered to the display. It consists of a single magic method which accepts
any type of asset to be called back later.

To add a CSS file, for example you could run,

```php
Keystone\Asset::addCssFile('/path/to/file.css');
```

Also available is passing in the raw source,

```php
Keystone\Asset::addCss('* html * { display:none; }');
```

Finally, you can retrieve any set asset with a similar get method,

```php
Keystone\Asset::getCss();
```