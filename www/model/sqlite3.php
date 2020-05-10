<?php
    // load up your config file
    require_once("../config/config.php");   
    /**
    * SQLite connnection
    */
    class SQLiteConnection {
        /**
        * PDO instance
        * @var type 
        */
        private $db = new SQLite3($config->db->file_path);


        public function query($query) {
            $results = $db->query($query);

            return $results;
        }
    }
?>