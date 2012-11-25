<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class executeCommandElement extends Element
{
  private $description = "";
  private $command;

  public function __construct($id, $typeId, $ofi, $data) {
    parent::__construct($id, $typeId, $ofi, $data);
   if (count($data) > 1) 
    $this->description = $data[1];
   $this->command = $data[0];
  }
  
  public function complete($websend, $userdata) {
    $websend->PHPcommand("cdplan " . $userdata->user_name . " " . str_replace("{PLAYER}", $userdata->user_name, $this->command));
  }
  
  public function getExplainString() {
    if ($this->description == "")
      return $this->command;
    else
      return $this->description;
  }
}