<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require("payement/payementType.php");
require("payement/payementPaypal.php");
require("payement/payementAllopass.php");
require("payement/payementStarpass.php");
require("payement/payementRentabiliweb.php");


class Payement_model extends CI_Model
{
  private $tablePayements = "shp_payements";
  private $payementTypes = array(1 => array("class" => "payementStarpass",
                                            "args" => "[AccountId]/[DocumentId]",
                                            "name" => "Starpass",
                                            "description" => "(Appel/Sms/Neosurf/Internet+)"),
                                 2 => array("class" => "payementRentabiliweb",
                                            "args" => "[SiteId]/[DocumentId]",
                                            "name" => "Rentabiliweb",
                                            "description" => "(Appel/Sms/Neosurf/Internet+/Paypal)"),
                                 3 => array("class" => "payementPaypal",
                                            "args" => "[Amount]/[LoginAPI]/[PwAPI]/[SignAPI]",
                                            "name" => "Paypal",
                                            "description" => "(Carte bleue/Paypal)"),
                                 4 => array("class" => "payementAllopass",
                                            "args" => "[SiteId]/[DocumentId]/[SecretId]",
                                            "name" => "Allopass",
                                            "description" => "(Appel/Sms/Neosurf/Internet+)"));
  
	public function __construct() {
    //$this->offers[1] = new PayementPaypal(1, "Paypal 50 tokens", "paypal_20.png", 5, 50);
    //$this->offers[2] = new PayementAllopass(2, "Allopass 10 tokens", "allopass_10.png", 10, "286713/1195216/5022277");
    //$this->offers[3] = new PayementStarpass(3, "Starpass 10 tokens", "starpass_10.png", 10, "43801/104586");
  }
  
  public function getPayementById($id) {
    return $this->craftPayement($this->db->query("SELECT * FROM " . $this->tablePayements . " WHERE payement_id = ?", array($id))->row_array());
  }
  
  public function craftPayement($dataPayement) {
    $classType = $this->payementTypes[$dataPayement["payement_type"]];
    $class = new ReflectionClass($classType["class"]);
    $payement = $class->newInstanceArgs(array($dataPayement));
    return $payement;
  }
  
  public function getAllPayements() {
    $finalArray = array();
    foreach ($this->db->query("SELECT * FROM " . $this->tablePayements . " ORDER BY payement_id;")->result_array() AS $dataPayement) {
      $finalArray[] = $this->craftPayement($dataPayement);
    }
    return $finalArray;
  }
  
  public function getPayementsByType($type_id) {
    $finalArray = array();
    foreach ($this->db->query("SELECT * FROM " . $this->tablePayements . " WHERE payement_type = ? ORDER BY payement_id;", array($type_id))->result_array() AS $dataPayement) {
      $finalArray[] = $this->craftPayement($dataPayement);
    }
    return $finalArray;
  }
  
  public function updatePayement($payement_id, $payData) {
    $this->db->where(array("payement_id" => $payement_id));
    return $this->db->update($this->tablePayements, $payData);
  }  
  
  public function createPayement($data) {
    $this->db->insert($this->tablePayements, $data);
    return $this->db->insert_id();
  }
  
  public function deletePayement($pay_id) {
    return $this->db->delete($this->tablePayements, array("payement_id" => $pay_id));
  }
  
  public function getPayementTypes() {
    return $this->payementTypes;
  }
  
  public function getTotalUsedPerPayement() {
    return $this->db->query("SELECT p.payement_name, COUNT( h.payement_id ) AS number_used
FROM  `shp_payements_history` AS h
INNER JOIN shp_payements AS p ON h.payement_offer_id = p.payement_id
GROUP BY h.payement_offer_id
ORDER BY number_used DESC 
LIMIT 0 , 30")->result();
  }
  
  // All about the logs
  private $tableHistory = "shp_payements_history";
  
  private function getTransactionsHistory($rest, $vars = array()) {
    return $this->db->query("SELECT * FROM " . $this->tableHistory . " AS h
                            INNER JOIN shp_users AS u
                              ON u.user_id = h.user_id
                              " . $rest, $vars);
  }
  
  public function getTransactionHistory($type, $keyid) {
    return $this->getTransactionsHistory("WHERE payement_offer_id = ? AND payement_keyid = ?", array($type, $keyid))->row();
  }
  
  public function addTransactionHistory($keyid, $user_id, $offerPayementId, $time) {
    $this->db->query("INSERT INTO " . $this->tableHistory . "(payement_keyid, user_id, payement_time, payement_offer_id) VALUES(?, ?, ?, ?)", array($keyid, $user_id, $time, $offerPayementId));
  }
  
  public function isNewTransaction($offer_id, $id) {
    return ($this->payement_model->getTransactionHistory($offer_id, $id) == FALSE);
  }
}