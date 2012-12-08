<?php
function simple_filter_array($keysToKeep, $data) {
    // On regarde chaque clé pour savoir si on la garde
    $resultArray = array();
    foreach($data AS $keyData => $lineData) {
      if (in_array($keyData, $keysToKeep)) {
        $resultArray[$keyData] = $lineData;
      }
    }
    return $resultArray;
}