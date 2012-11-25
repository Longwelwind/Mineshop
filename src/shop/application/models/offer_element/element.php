<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


abstract class Element
{
  //private $applyServerId;

  protected $typeId;
  protected $id;
  protected $offer_id;
  
  public function __construct($id, $typeId, $offer_id, $data) {
    $this->typeId = $typeId;
    $this->id = $id;
    $this->offer_id = $offer_id;
    $this->data = $data;
  }
  
  public function getTypeId() {
    return $this->typeId;
  }
  
  public function getOfferId() {
    return $this->offer_id;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function getData() {
    return $this->data;
  }
  
  public abstract function complete($webSendObject, $userdata);
  public abstract function getExplainString();
}