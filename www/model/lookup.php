<?php
    // load up your config file
    require_once("../config/config.php");  
    require_once(MODEL_PATH . "/sqlite3.php");
    
    Class LookUp {
        private $sqlite3;
        
        function __construct() {
            // Create a new connection to the sqlite3 database
            $this->sqlite3 = new SQLiteConnection();
        }

        public function lookupForDNS($dns) {
            // Create an array with the results
            $aResult = array(
                "NS" => @dns_get_record($dns, DNS_NS),
                "A" => @dns_get_record($dns, DNS_A)
            );
            // Insert the results into the database
            return $this->insertLookup($dns, $aResult);
        }

        private function insertLookup($dns, $dns_result) {
            // Check if the domain info already exists
            $aResult = $this->getDomainResult($dns);

            // if already exists, use the same domain id and only update the record
            if(count($aResult) > 0) {
                if(count($dns_result['A']) > 0 && count($dns_result['NS']) > 0) {
                    // insert the record
                    $this->insertIntoRecord($aResult[0]['id'], $dns_result);
                }
                else {
                    // It wasn't possible to retrieve info from dns_record
                    return array("type" => "alert", "msj" => "No data found or domain invalid");
                }
            }
            else {
                // Insert into result
                $iNewId = $this->insertIntoResult($dns);

                if(count($dns_result['A']) > 0 && count($dns_result['NS']) > 0) {
                    // Insert the record
                    $this->insertIntoRecord($iNewId, $dns_result);
                }
                else {
                    // It wasn't possible to retrieve info from dns_record
                    return array("type" => "alert", "msj" => "No data found or domain not valid");
                }
            }
            // Everything went as expected
            return array("type" => "alert", "msj" => "Lookup performed successfully");
        }

        private function getDomainResult($dns) {
            // get the domain details if any
            $aResult = $this->sqlite3->query(
                "SELECT *" .
                " FROM \"domain_result\"" .
                " WHERE \"domain\" = '" . $dns . "'"
            );

            if(count($aResult) > 0) {
                return $aResult;
            }
            else {
                return array();
            }
        }

        private function insertIntoResult($dns) {
            // Insert the results of the domain queried by user
            $this->sqlite3->insertUpdateDelete(
                "INSERT INTO \"domain_result\"" .
                " VALUES (" .
                    "(SELECT ifnull(max(id),0)+1 FROM \"domain_result\"), " .
                    "'" . $dns . "'" . 
                ")"
            );

            // Get the ID of this new domain queried by the user
            $aResult = $this->sqlite3->query(
                "SELECT ifnull(max(id), 0) as id" .
                " FROM \"domain_result\""
            );

            if(count($aResult) > 0) {
                return $aResult[0]['id'];
            }
            else {
                return 0;
            }
        }

        private function insertIntoRecord($dns_id, $dns_result) {
            // remove old DNS lookup record, keep only fresh valid data
            $this->sqlite3->insertUpdateDelete(
                "DELETE FROM \"domain_record\"" . 
                " WHERE domain_id = " . $dns_id
            );

            for($i = 0; $i < count($dns_result['A']); $i++) {
                // Insert all the DNS A records we got
                $this->sqlite3->insertUpdateDelete(
                    "INSERT INTO \"domain_record\"" . 
                    " VALUES (" .
                        "(SELECT ifnull(max(id),0)+1 FROM \"domain_record\"), " .
                        $dns_id . ", " .
                        "'" . $dns_result['A'][$i]['type']. "', " .
                        ($i+1) . ", " . 
                        "NULL, " .
                        "'" . $dns_result['A'][$i]['ip'] . "'" .
                    ")"
                );
            }

            for($i = 0; $i < count($dns_result['NS']); $i++) {
                // Insert all the DNS NS records we got
                $this->sqlite3->insertUpdateDelete(
                    "INSERT INTO \"domain_record\"" . 
                    " VALUES (" .
                        "(SELECT ifnull(max(id),0)+1 FROM \"domain_record\"), " .
                        $dns_id . ", " .
                        "'" . $dns_result['NS'][$i]['type']. "', " .
                        ($i+1) . ", " . 
                        "'" . $dns_result['NS'][$i]['target'] . "', " .
                        "NULL" .
                    ")"
                );
            }

            return true;
        } 

        public function getLookupResults($dns = "") {
            // Get the results we have stored at the database
            $aFinalResult = array();

            $sQuery = 
                "SELECT *" .
                " FROM \"domain_result\"";

            if(trim($dns) != "") {
                // If we are looking for a specific DNS
                $sQuery .= 
                    " WHERE domain = '" . $dns . "'";
            }
            else {
                // Get the last 10 requests
                $sQuery .= 
                    " ORDER BY id DESC" .
                    " LIMIT 10";
            }

            $aDomainResult = $this->sqlite3->query($sQuery);

            for($i = 0; $i < count($aDomainResult); $i++) {
                // Get the A and NS records of the specific domain (or last 10 requests if domain parameter is empty)
                $sQuery = 
                    "SELECT d.domain, dr.record_type, dr.target, dr.ip" .
                    " FROM \"domain_result\" d" .
                    " INNER JOIN \"domain_record\" dr" .
                    " ON dr.domain_id = d.id" .
                    " WHERE d.id = " . $aDomainResult[$i]['id'];

                $aDomainRecords = $this->sqlite3->query($sQuery);

                if(count($aDomainRecords) > 0) {
                    array_push($aFinalResult, $aDomainRecords);
                }
            }

            if(count($aFinalResult) > 0) {
                return $aFinalResult;
            }
            else {
                return array();
            }
        }
    }
?>