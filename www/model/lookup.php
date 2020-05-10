<?php
    Class LookUp {
        public function lookupForDNS($dns) {
            $aResult = array(
                $dns => @dns_get_record($dns)
            );

            insertLookup($aResult);

            return $aResult;
        }

        public function insertLookup($dns_result) {
            
        }
    }
?>