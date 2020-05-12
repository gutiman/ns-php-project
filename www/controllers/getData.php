<?php 
    // Get config details
    require_once("../config/config.php");
    // Get model
    require_once(MODEL_PATH . "/lookup.php");

    Class GetData {
        private $lookup;

        function __construct() {
            $this->lookup = new LookUp();
        }

        function getLatestDomains() {
            // call model method and return result
            $aResult = $this->lookup->getLookupResults();
            return $aResult;
        }
    }    
?>