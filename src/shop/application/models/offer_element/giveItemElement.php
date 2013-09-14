<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class giveItemElement extends Element
{
  private $number;
  private $itemId;
  private $name;
  private $metadata = 0;
  private $enchant = "";
  private $enchant_level;

  public function __construct($id, $typeId, $ofi, $data) {
   parent::__construct($id, $typeId, $ofi, $data);
   
   $this->number = $data[0];
   $this->name = $data[1];
   $this->itemId = $data[2];
   if (count($data) > 3) {
    $this->metadata = $data[3];
    if (count($data) > 5) {
      $this->enchant = $data[4];
      $this->enchant_level = $data[5];
    }
   }
  }
  
  public function complete($websend, $userdata) {
    $enchant_part = ($this->enchant != "") ? " " . $this->enchant . ":" . $this->enchant_level : "" ;
    $websend->PHPcommand("cdplan " . $userdata->user_name . " give " . $userdata->user_name . " " . $this->itemId . ":" . $this->metadata . " " . $this->number . $enchant_part);
  }
  
  public function getExplainString() {
    if ($this->metadata > 0)
      return $this->number . "x " . $this->name;
    else
      return $this->number . "x " . $this->name;
  }
}
