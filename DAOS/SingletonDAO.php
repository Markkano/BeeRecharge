<?php namespace Daos;

/*abstract*/ class SingletonDAO {
	  private static $instances = array();

	  public static function getInstance() {
	    $class = get_called_class();
	    if (!isset(self::$instances[$class])) {
	      self::$instances[$class] = new $class();
	    }
	    return self::$instances[$class];
	  }
	}
?>
