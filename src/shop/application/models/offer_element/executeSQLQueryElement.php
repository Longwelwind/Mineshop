<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class executeSQlQueryElement extends Element
{
  private $description = "";
  private $query;

  public function __construct($id, $typeId, $ofi, $data) {
    parent::__construct($id, $typeId, $ofi, $data);
   if (count($data) > 1) 
    $this->description = $data[1];
    $this->query = $data[0];
  }
  
  public function complete($websend, $userdata) {
    global $CI;
    $CI->db->query(str_replace("{PLAYER}", $CI->db->escape($userdata->user_name), $this->query));
  }
  
  public function getExplainString() {
    if ($this->description == "")
      return $this->command;
    else
      return $this->description;
  }
}