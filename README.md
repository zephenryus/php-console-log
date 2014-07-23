It's console.log() for PHP! PHP Console is a class that is modeled after Chrome's console API. It allows console logging from PHP via Javascript.

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

Examples
--------

```php
<?php

require_once "Console.php";

$console = new Console();


/**
 * Returns the nth value of the fibonacci sequence.
 * @param  Integer $n The index of the fibonacci sequence
 * @return Integer    The nth value of the fibonacci sequence
 */
function fibonacci ( $n ) {
	global $console;				// Reference global $console
	$console->log( $n );			// Log $n passed to the function
	if ( $n <= 2 )
		return 1;
	return fibonacci( $n - 1 ) + fibonacci( $n - 2 );
}

$console->log( fibonacci( 4 ) );	// Log the 4th number in the fibonacci sequence (3)

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>untitled</title>
</head>
<body>
	
</body>
<?php
	/**
	 * $console->export() exports the values logged to javascript.
	 * Based on what is logged above it should print
	 * 
	 * <script>console.log( 4 + "  %ctest.php:9", "color: blue; font-style: italic;" );
	 * console.log( 3 + "  %ctest.php:9", "color: blue; font-style: italic;" );
	 * console.log( 2 + "  %ctest.php:9", "color: blue; font-style: italic;" );
	 * console.log( 1 + "  %ctest.php:9", "color: blue; font-style: italic;" );
	 * console.log( 2 + "  %ctest.php:9", "color: blue; font-style: italic;" );
	 * console.log( 3 + "  %ctest.php:16", "color: blue; font-style: italic;" );
	 * </script>
	 *
	 * into the document.
	 */
	$console->export(); // This exports the logs to javascript
?>
</html>
```

This would give the following output in the browser's console

![Console Output](https://raw.githubusercontent.com/zephenryus/zephenryus.github.io/master/images/console-1.png "Console Output")
