<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class groupManagerPromoteElement extends Element
{
  private $group;

  public function __construct($id, $typeId, $ofi, $data) {
    parent::__construct($id, $typeId, $ofi, $data);
    $this->group = $data[0];
  }
  
  public function complete($websend, $userdata) {
    $websend->PHPcommand("cdplan " . $userdata->user_name . " manuadd " . $userdata->user_name . " " . $this->group);
    $websend->PHPcommand("cdplan " . $userdata->user_name . " mansave");
  }
  
  public function getExplainString() {
    return "Rang \"" . $this->group . "\"";
  }
}