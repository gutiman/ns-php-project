<?php
    $aResult = array();

    try {
        // load up your config file
        require_once("../config/config.php");     

        if(isset($_REQUEST['model']) && isset($_REQUEST['function']) && isset($_REQUEST['dns_lookup']) && trim($_REQUEST['model']) != "" && trim($_REQUEST['function']) != "" && trim($_REQUEST['dns_lookup']) != "") {
            require_once(MODEL_PATH . "/" . $_REQUEST['model'] . ".php");
            $model = new $_REQUEST['model']();
            $function = $_REQUEST['function'];

            $aDNS = explode(",", $_REQUEST['dns_lookup']);
            
            for($i = 0; $i < count($aDNS); $i++) {
                $aRecord = $model->$function($aDNS[$i]);
                
                if(is_array($aRecord)) {
                    $aResult = array_merge($aResult, $aRecord);
                }
                /* else {
                    var_dump($aRecord);
                } */
            }

            echo json_encode($aResult);
        }
        else {
            throw new Exception("Empty model, function name or domains list", 1);
        }        
    } catch (\Exception $th) {
        $aResult = array("error" => array("type" => "alert", "msj" => $th->getMessage()));
        echo json_encode($aResult);
    }
?>