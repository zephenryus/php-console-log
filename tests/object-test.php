<?php

require_once "Console.php";

$console = new Console();

class foo {

	public $a, $b, $c, $d, $e, $f, $g;
	private $h, $i, $j, $k, $l, $m;

	function __construct( $var ) {
		$this->a = $var;
		$this->b = true;
		$this->c = 42;
		$this->d = 3.14;
		$this->e = "Hello";
		$this->f = array( 1, 2, 3, 4 );
		$this->g = NULL;
		$this->h = true;
		$this->i = 42;
		$this->j = 3.14;
		$this->k = "Hello";
		$this->l = array( 1, 2, 3, 4 );
		$this->m = NULL;
	}
}

$console->log( new foo( "bar" ) );

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
	$console->export();
?>
</html>