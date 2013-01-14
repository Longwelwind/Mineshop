<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class giveXpElement extends Element
{
  private $number;

  public function __construct($id, $typeId, $ofi, $data) {
    parent::__construct($id, $typeId, $ofi, $data);
   $this->number = $data[0];
  }
  
  public function complete($websend, $userdata) {
    $websend->command("cdplan " . $userdata->user_name . " xp give " . $userdata->user_name . " " . $this->number);
  }
  
  public function getExplainString() {
    return $this->number . " points d'expérience";
  }
}