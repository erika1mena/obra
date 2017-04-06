<?php
ini_set('display_errors', 'on');

class PostgresException extends Exception {
    function __construct($msg) { parent::__construct($msg); }
}

class DependencyException extends PostgresException {
    function __construct() { parent::__construct("deadlock"); }
}

class pg{
    public static $connection;
    
    private static function connect() {
        self::$connection = @pg_connect("host=127.0.0.1 port=5433 dbname=PryTeatro user=postgres password=admin");
        if (self::$connection === FALSE) {
            throw(new PostgresException("Can't connect to database server."));
        }
    }
    
    public static function query($sql) {
        if (!isset(self::$connection)) {
            self::connect();
        }
        
        $result = @pg_query(self::$connection, $sql);
        if ($result === FALSE) {
            $error = pg_last_error(self::$connection);
            if (stripos($error, "deadlock detected") !== false) throw(new DependencyException());
            
            throw(new PostgresException($error.": ".$sql));
        }
        
        /*$out = array();
        while ( ($d = pg_fetch_assoc($result)) !== FALSE) {
            $out[] = $d;
        }*/

        return $result;
    }
}
?>
