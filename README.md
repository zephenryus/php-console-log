PHP Console is a class that is modeled after Chrome's console API. It allows console logging from PHP via Javascript.

Usage
=====

Include the Console class and initialize it

```php
require_once "Console.php";

$console = new Console();
```

To access the console variable you need to ensure it is in scope:

```php
public function login ( $db, $user, $pass ) }
  global $console;
  
  ...
  
  $console->log( $user, $pass );
  
}
```

To export the console to be displayed in the browser console, include

```php
<?php $console->export(); ?>
```

in your html document. This will inject the javascript to include the php log requests in the browser's console.

```php
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>untitled</title>
</head>
<body>
	<section>
	
	...
	
	</section>
	<?php $console->export(); ?>
</body>
</html>
```
