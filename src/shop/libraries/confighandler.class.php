<?php

function confighandler_getConfig($path_url) {
    $file = fopen("config.txt", "r");
    $config = array();
    while (!feof($file)) {
        $data = explode("=", fgets($file));
        if ($data[0] != "") {
            $config[$data[0]] = str_replace("\n", "", str_replace("\r", "", $data[1]));
        }

    }
    fclose($file);
    return $config;
}

function confighandler_setConfig($path_url, $config) {
    $file = fopen("config.txt", "w");
    foreach ($config AS $key => $value) {
        fwrite($file, $key . "=" . $value . "\n");
    }
    fclose($file);
}
?>
