<!doctype html>
<?php
    // load up your config file
    require_once("./config/config.php");      
?>
<html class="no-js" lang="en">      
    <?php
        require_once(DECORATORS_PATH . "/head.php");
    ?>

    <div id="grid-container fluid">
        <div class="grid-x">
            <div class="cell text-center" id="callout"></div>
        </div>

        <div class="grid-x">
            <!-- content -->
            <?php 
                require_once(CONTROLLERS_PATH . "/viewController.php");

                $controller = new ViewController();
                echo $controller->getView('main_form');
            ?>            
        </div>
    </div>

    <?php
        require_once(DECORATORS_PATH . "/foot.php");
    ?>
</html>