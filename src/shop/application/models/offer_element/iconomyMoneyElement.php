<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class IconomyMoneyElement extends Element
{
  private $rewardMoney;

  public function __construct($id, $typeId, $ofi, $data) {
    parent::__construct($id, $typeId, $ofi, $data);
    $this->rewardMoney = $data[0];
  }
  
  public function complete($websend, $userdata) {
    $websend->command("money give " . $userdata->user_name . " " . $this->rewardMoney);
  }
  
  public function getExplainString() {
    return "Donne " . $this->rewardMoney . "$ iConomy.";
  }
}