<?php
    // Array where all the results will be saved
    $aResult = array();

    try {
        // load up config file
        require_once("../config/config.php");     

        // If the model, the function and the dns_lookup are defined and contains values
        if(
            isset($_REQUEST['model']) && 
            isset($_REQUEST['function']) && 
            isset($_REQUEST['dns_lookup']) && 
            trim($_REQUEST['model']) != "" && 
            trim($_REQUEST['function']) != "" && 
            trim($_REQUEST['dns_lookup']) != ""
        ) {
            // get the model class
            require_once(MODEL_PATH . "/" . $_REQUEST['model'] . ".php");
            // instantiate
            $model = new $_REQUEST['model']();
            $function = $_REQUEST['function'];

            // Make the list into an array
            $aDNS = explode(",", $_REQUEST['dns_lookup']);
            
            // For each value entered by the user
            for($i = 0; $i < count($aDNS); $i++) {
                // Call the function of the model with the info
                $aRecord = $model->$function($aDNS[$i]);
                
                if(is_array($aRecord)) {
                    // merge the new results with the values we already have
                    $aResult = array_merge($aResult, $aRecord);
                }
            }
            // Return a JSON
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