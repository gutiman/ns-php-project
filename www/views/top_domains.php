<?php 
    require_once("../config/config.php");
    require_once(CONTROLLERS_PATH . "/getData.php");

    try {
        $getData = new GetData();
        $aResult = $getData->getLatestDomains();
    }
    catch(Exception $e) {
        print_r($e->getMessage());
    }

    if(count($aResult) > 0) {
?>

<form id="form_top_domains">
    <fieldset>
        <legend>Latest domain lookups </legend>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell">
                    <table class="hover stack">
                        <thead>
                            <th>Domain</th>
                            <th>Record Type</th>
                            <th>Value</th>
                        </thead>
                        <tbody>
                            <?php
                                for($i = 0; $i < count($aResult); $i++) {
                                    for($j = 0; $j < count($aResult[$i]); $j++) {
                                        echo "<tr>";
                                        echo "<td>" . $aResult[$i][$j]['domain'] . "</td>";
                                        echo "<td>" . $aResult[$i][$j]['record_type'] . "</td>";
                                        if(trim($aResult[$i][$j]['target']) != "") {
                                            echo "<td>" . $aResult[$i][$j]['target'] . "</td>";
                                        }
                                        else {
                                            echo "<td>" . $aResult[$i][$j]['ip'] . "</td>";
                                        }
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<?php
    }
?>