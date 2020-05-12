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
        private $db = null;

        function __construct() {
            // open the database in read/write mode
            $this->db = new SQLite3(CONFIG['db']['file_path'], SQLITE3_OPEN_READWRITE);
        }

        public function query($query) {
            // This function is valid for selects
            try {
                $aResults = array();
                $results = $this->db->query($query);
                
                while ($aRow = $results->fetchArray(SQLITE3_ASSOC)) {
                    array_push($aResults, $aRow);
                }

                return $aResults;
            }
            catch(\Exception $e) {
                return $e->getMessage();
            }
        }

        public function insertUpdateDelete($query) {
            // This function does not return the result set, therefore, it is useful for non result queries like insert/update/delete
            try {
                $aResults = array();
                $results = $this->db->query($query);
                
                return true;
            }
            catch(\Exception $e) {
                return $e->getMessage();
            }
        }
    }
?>