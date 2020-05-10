<?php
    $aResult = array();

    try {
        // load up your config file
        require_once("../config/config.php");     

        if(trim($_REQUEST['model']) != "") {
            require_once(MODEL_PATH . "/" . $_REQUEST['model'] . ".php");
            $model = new $_REQUEST['model']();

            $aDNS = explode(",", $_REQUEST['dns_lookup']);

            for($i = 0; $i < count($aDNS); $i++) {
                $aResult = array_merge($aResult, $model->lookupForDNS($aDNS[$i]));
            }

            echo json_encode($aResult);
        }
        else {
            throw new Exception("Empty model name", 1);
        }        
    } catch (\Exception $th) {
        $aResult = array("error" => array("type" => "alert", "msj" => $th->getMessage()));
        echo json_encode($aResult);
    }
?>