![PHP Console Log Logo](https://raw.githubusercontent.com/zephenryus/zephenryus.github.io/master/images/php-console-log-logo.png "PHP Console Log Logo")

It's console.log() for PHP!

PHP console::log is a class that is modeled after Chrome's console API. The console class is a wrapper class that inserts logs from PHP into the browser's console.

![Demo Output](https://raw.githubusercontent.com/zephenryus/zephenryus.github.io/master/images/console-demo-image.png "Demo Output")

Usage
=====

Include the console class

```php
require_once "console.php";
```

Variables, objects and arrays can then be passed to the console. The logs are automatically exported to the console.

```php
console::log( "hello world!" );
```

For more information check out the [wiki](https://github.com/zephenryus/php-console-log/wiki)
