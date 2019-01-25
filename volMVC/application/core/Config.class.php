<?php
/*
*	Holds the config params
*
*/

class Config {
	// attribs
    private static $confIni = "config.ini";
	private static $debug = 1;
	private static $instance;
	
	
	/**
	 * Parses the config file
	 * @return object returns db config parameters
	 */
	public static function getDbParams(){
		if(!is_null(self::$instance)){
			$instance = new self();
		}  
		return self::$instance;
	}

	private function __construct(){
		$parse = parse_ini_file(self::$confIni, true);
		return (object)$parse['database'];
	}

	/**
	 * Duplication prevention declarations
	 */

	private function __clone(){

	}

	private function __wakeup(){

	}

}
