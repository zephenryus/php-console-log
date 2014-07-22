<?php
class Log {
	public $var;
	public $file;
	public $line;

	function __construct ( $var, $file, $line ) {
		$this->var = $var;
		$this->file = $file;
		$this->line = $line;
	}
}
/**
 * Modeled after Chrome's console API
 *
 * console.assert(expression, object)
 * console.clear()
 * console.count(label)
 * console.debug(object [, object, ...])
 * console.dir(object)
 * console.dirxml(object)
 * console.error(object [, object, ...])
 * console.group(object[, object, ...])
 * console.groupCollapsed(object[, object, ...])
 * console.groupEnd()
 * console.info(object [, object, ...])
 * console.log(object [, object, ...])
 * console.profile([label])
 * console.profileEnd()
 * console.time(label)
 * console.timeEnd(label)
 * console.timeline(label)
 * console.timelineEnd()
 * console.timeStamp([label])
 * console.trace(object)
 * console.warn(object [, object, ...])
 * debugger
 */
class Console {
	private $messageLog;

	public function assert ( $expression, $object ) {
		// TODO
	}


	/**
	 * Displays a message in the console. You pass one or more objects to this 
	 * method, each of which are evaluated and concatenated into a
	 * space-delimited string. The first parameter you pass to log() may
	 * contain format specifiers, a string token composed of the percent sign 
	 * (%) followed by a letter that indicates the formatting to be applied.
	 * 
	 * $console->log( object [, object, ...] )
	 * 
	 * @return [type] [description]
	 */
	public function log () {
		// Find where Console::log() was called
		$backtrace = debug_backtrace();
		preg_match( "/(?=\w+\.\w{3,4}$).+/", $backtrace[0]["file"], $match );
		$file = $match[0];

		$args = func_get_args();
		foreach ( $args as $var ) {
			$logEntry = new Log( $var, $file, $backtrace[0]["line"] );
			array_push( $this->messageLog, $logEntry );
		}
	}


	/**
	 * console.debug(object [, object, ...])
	 * This method is identical to console.log().
	 * @return [type] [description]
	 */
	public function debug () {
		$args = func_get_args();
		$this->log( $args );
	}

	public function info () {
		$args = func_get_args();
		$this->log( $args );
	}

	/**
	 * This exports the required javascript to put the PHP Console in the
	 * browser console
	 * 
	 * @return [type] [description]
	 */
	public function export () {
		if ( !empty( $this->messageLog ) ) {
			$sep = "";
			print "<script>";
			foreach ( $this->messageLog as $log ) {
				if ( !is_object( $log->var ) && !is_array( $log->var ) ) {
					print "console.log( " . json_encode( $log->var ) . " + \"  %c$log->file:$log->line\", \"color: blue; font-style: italic;\" );\n";
				} else {
					print "console.log( \"%c$log->file:$log->line:\", \"color: blue; font-style: italic;\" );\n";
					print "console.log( " . json_encode( $log->var ) . " );\n";
				}
			}
			print "</script>";
		}
	}

	function __construct () {
		$this->messageLog = array();
	}
}


?>
