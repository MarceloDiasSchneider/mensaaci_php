<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
class DatabasePdoClass
{

    static $object;

    static public function getInstance()
    {
        if (!isset(self::$object)) {
            self::$object = new DatabasePdoClass();
        }
        return self::$object;
    }

    public function creaConnessione()
    {

        $whitelist = array('localhost', '127.0.0.1', '192.168.33.31');
        $ovhlist = array('51.91.97.200');
        if (in_array($_SERVER['HTTP_HOST'], $whitelist)) {
            // echo "locale";
            ini_set('display_errors', 1);
            // error_reporting('E_ALL');
            ini_set('display_startup_errors', 1);


            $config = array(
                'host' => '107.180.25.194',
                'username' => 'MarceloSchneider',
                'password' => 'pfekr3sJ22VjzH8',
                'dbname' => 'mensa_aci'
            );
            // error_reporting('E_ALL');
        } else if (in_array($_SERVER['HTTP_HOST'], $ovhlist)) {

            $config = array(
                'host' => '107.180.25.194',
                'username' => 'MarceloSchneider',
                'password' => 'pfekr3sJ22VjzH8',
                'dbname' => 'mensa_aci'
            );
            // error_reporting('E_ALL');
        }
        try {
            // connessione tramite creazione di un oggetto PDO

            $db = new PDO('mysql:charset=utf8;host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;
        }
        // blocco catch per la gestione delle eccezioni
        catch (PDOException $e) {
            echo __LINE__ . __FILE__ . __FUNCTION__ . '  Attenzione problemi di connessione al db: ' . $e->getMessage();
        }
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    public function __wakeup()
    {
    }
}
