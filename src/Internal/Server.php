<?php

namespace Interal;

class Server {

    public static function run() {
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);

    }

    public function loadAllConfigs(array $exclude = []) {

    }

}