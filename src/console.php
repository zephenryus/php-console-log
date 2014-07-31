<?php
/**
 * PHP 5 >= 5.2.0
 */

define( "CONSOLE_TYPE_LOG", "log" );
define( "CONSOLE_TYPE_WARN", "warn" );
define( "CONSOLE_TYPE_ERROR", "error" );
define( "CONSOLE_TYPE_CLEAR", "clear" );
define( "CONSOLE_TYPE_GROUP", "group" );
define( "CONSOLE_TYPE_GROUP_COLLAPSED", "groupCollapsed" );
define( "CONSOLE_TYPE_GROUP_END", "groupEnd" );

define( "CONSOLE_FILE_LINE_STYLE", "color: #3f5aa1; font-style: italic; text-decoration: underline;" );

class console {
	// TODO: Migrate global defines to class constants
	// const CONSOLE_TYPE_LOG = "log";

	public static $messageLog = array();
	public static $counters = array();
	public static $timers = array();

	public static function assert ( $exp, $msg ) {
		$backtrace = debug_backtrace();
		if ( !$exp ) {
			self::addLog( CONSOLE_TYPE_ERROR, $backtrace, "Assertion failed: " . $msg );
		}
	}

	public static function clear () {
		$backtrace = debug_backtrace();
		self::addLog( CONSOLE_TYPE_CLEAR, $backtrace );
	}

	private static function addLog ( $type, $backtrace, $args = array( 0 ) ) {
		// TODO: sanitize $type

		preg_match( "/(?=[\w-]+\.[A-Za-z]{3,4}$).+/", $backtrace[0]["file"], $match );
		$file = $match[0];
		$line = $backtrace[0]["line"];

		if ( !is_array( $args ) ) {
			$args = array( $args );
		}

		foreach ( $args as $var ) {
			array_push( self::$messageLog, new Log( $type, $var, $file, $line ) );
		}
	}

	public static function count ( $label ) {
		// TODO
	}

	public static function debug () {
		$backtrace = debug_backtrace();
		$args = func_get_args();
		self::addLog( CONSOLE_TYPE_LOG, $backtrace, $args );
	}

	/*
	public static function dir ( $obj ) {
		// This function does not seem to apply to PHP
		// TODO
	}
	 */

	/*
	public static function dirxml ( $obj ) {
		// This function does not seem to apply to PHP
		// TODO
	}
	 */

	public static function error () {
		$backtrace = debug_backtrace();
		$args = func_get_args();
		self::addLog( CONSOLE_TYPE_ERROR, $backtrace, $args );
	}

	public static function group () {
		$backtrace = debug_backtrace();
		$args = func_get_args();

		if ( !is_array( $args ) || count( $args ) == 1 ) {
			self::addLog( CONSOLE_TYPE_GROUP, $backtrace, $args );
		} else {
			$tmp = array_shift( $args );
			self::addLog( CONSOLE_TYPE_GROUP, $backtrace, $tmp );
			self::addLog( CONSOLE_TYPE_LOG, $backtrace, $args );
		}
	}

	public static function groupCollapsed () {
		$backtrace = debug_backtrace();
		$args = func_get_args();

		if ( !is_array( $args ) || count( $args ) == 1 ) {
			self::addLog( CONSOLE_TYPE_GROUP_COLLAPSED, $backtrace, $args );
		} else {
			$tmp = array_shift( $args );
			self::addLog( CONSOLE_TYPE_GROUP_COLLAPSED, $backtrace, $tmp );
			self::addLog( CONSOLE_TYPE_LOG, $backtrace, $args );
		}
	}

	public static function groupEnd () {
		$backtrace = debug_backtrace();
		self::addLog( CONSOLE_TYPE_GROUP_END, $backtrace );
	}

	public static function info () {
		$backtrace = debug_backtrace();
		$args = func_get_args();
		self::addLog( CONSOLE_TYPE_LOG, $backtrace, $args );
	}

	public static function log () {
		$backtrace = debug_backtrace();
		$args = func_get_args();
		self::addLog( CONSOLE_TYPE_LOG, $backtrace, $args );
	}

	public static function profile ( $label ) {
		// I will have to find a way to mimic the profiler on the server side
		// If I do implement it I will also have to find a way to display it
		// TODO
	}
	
	public static function profileEnd () {
		// TODO
	}
	
	public static function time ( $label ) {
		// TODO
	}

	public static function timeEnd ( $label ) {
		// TODO
	}

	public static function timeline ( $label ) {
		// TODO
	}

	public static function timelineEnd () {
		// TODO
	}

	public static function timeStamp ( $label ) {
		// TODO
	}

	public static function trace ( $obj ) {
		// TODO
	}

	public static function var_dump () {
		$backtrace = debug_backtrace();
		$args = func_get_args();
		self::addLog( CONSOLE_TYPE_LOG, $backtrace, $args );
	}

	public static function warn () {
		$backtrace = debug_backtrace();
		$args = func_get_args();
		self::addLog( CONSOLE_TYPE_WARN, $backtrace, $args );
	}

	public static function export () {
		if ( !empty( self::$messageLog ) ) {
			print "<script>\nif ( window.console && console && console.log ) {\n";

			foreach ( self::$messageLog as $log ) {
				switch ( $log->type ) {

					case CONSOLE_TYPE_CLEAR:
						print "console.clear();" . PHP_EOL;
						break;

					case CONSOLE_TYPE_ERROR:
						print "console.group('%c$log->file:$log->line', '" . CONSOLE_FILE_LINE_STYLE . "' );" . PHP_EOL
							. "console.error( " . json_encode( $log->var ) . " );" . PHP_EOL
							. "console.groupEnd();";
						break;

					case CONSOLE_TYPE_GROUP:
						print "console.group('%c$log->file:$log->line', '" . CONSOLE_FILE_LINE_STYLE . "' );" . PHP_EOL
							. "console.group( " . json_encode( $log->var ) . " );" . PHP_EOL;
						break;

					case CONSOLE_TYPE_GROUP_COLLAPSED:
						print "console.group('%c$log->file:$log->line', '" . CONSOLE_FILE_LINE_STYLE . "' );" . PHP_EOL
							. "console.groupCollapsed( " . json_encode( $log->var ) . " );" . PHP_EOL;
						break;

					case CONSOLE_TYPE_GROUP_END:
						print "console.groupEnd();" . PHP_EOL
							. "console.groupEnd();";
						break;

					case CONSOLE_TYPE_WARN:
						print "console.group('%c$log->file:$log->line', '" . CONSOLE_FILE_LINE_STYLE . "' );" . PHP_EOL
							. "console.warn( " . json_encode( $log->var ) . " );" . PHP_EOL
							. "console.groupEnd();";
						break;

					case CONSOLE_TYPE_LOG:
					default:
						print "console.group('%c$log->file:$log->line', '" . CONSOLE_FILE_LINE_STYLE . "' );" . PHP_EOL
							. "console.log( " . json_encode( $log->var ) . " );" . PHP_EOL
							. "console.groupEnd();" . PHP_EOL;
				}

			}
			print "}\n</script>";
		}
	}
}

class Log {
	public $type;
	public $var;
	public $file;
	public $line;

	function __construct ( $type, $var, $file, $line ) {
		$this->type = $type;
		$this->var = $var;
		$this->file = $file;
		$this->line = $line;
	}
}

class Timer {


	function __construct () {

	}
}

// This will defer insertion of the export method to the very end of the html document and ensures that ALL php calls to console are complete
function exportConsole () { console::export(); }
register_shutdown_function( "exportConsole" );

?>
