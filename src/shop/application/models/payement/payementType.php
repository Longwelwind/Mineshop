<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class PayementType {
  public function __construct($data) {
    foreach ($data AS $key => $dataValue) {
      $this->$key = $dataValue;
    }
  }
  
  abstract public function displayPayementPage($user_id);
}