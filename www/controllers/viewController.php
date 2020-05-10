<?php
    Class ViewController {
        public function getView($view) {
            include(TEMPLATES_PATH . "/" . $view . ".php");
        }
    }
?>