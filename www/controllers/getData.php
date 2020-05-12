<?php 
    require_once("../config/config.php");
    require_once(MODEL_PATH . "/lookup.php");

    Class GetData {
        private $lookup;

        function __construct() {
            $this->lookup = new LookUp();
        }

        function getLatestDomains() {
            $aResult = $this->lookup->getLookupResults();
            return $aResult;
        }
    }    
?>