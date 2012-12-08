<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require("offer_element/element.php");
require("offer_element/iconomyMoneyElement.php");
require("offer_element/groupManagerPromoteElement.php");
require("offer_element/giveItemElement.php");
require("offer_element/giveXpElement.php");
require("offer_element/executeCommandElement.php");
require("offer_element/executeSQLQueryElement.php");

class Offer_model extends CI_Model
{
  private $tableOffers = "shp_offers";
  
  public function getAllOffers() {
    return $this->getOffers()->result();
  }
  
  private function getOffers($rest = "", $array = array()) {
    //$rest = ($rest == "") ? "WHERE offer_deleted = 0" : $rest . " AND offer_deleted = 0";
    return $this->db->query("SELECT * FROM " . $this->tableOffers . " " . $rest, $array);
  }
  
  public function getOfferById($offer_id) {
    return $this->getOffers("WHERE offer_id = ? AND offer_deleted = 0", array($offer_id))->row();
  }
  
  public function getOffersByCategoryId($cate_id) {
    return $this->getOffers("WHERE offer_category_id = ? AND offer_deleted = 0 ORDER BY offer_order", array($cate_id))->result();
  }
  
  public function updateOffer($offerData, $offer_id) {
    $this->db->where("offer_id", $offer_id);
    $this->db->update($this->tableOffers, $offerData);
  }
  
  public function createOffer($offerData) {
    $this->db->insert($this->tableOffers, $offerData);
  }
  
  public function deleteOffer($offer_id) {
    $this->updateOffer(array("offer_deleted" => 1), $offer_id);
    //$this->db->delete($this->tableOffers, array("offer_id" => $offer_id));
  }
  
  public function getAmountTokensByDayForActualMonth() {
	return $this->db->query("SELECT SUM( shp_offers.offer_price ) AS sum_tokens
FROM  `shp_offers_history` 
INNER JOIN  `shp_offers` ON shp_offers.`offer_id` =  `shp_offers_history`.offer_id
WHERE MONTH( CURRENT_DATE( ) ) = MONTH( FROM_UNIXTIME(  `offer_history_time` ) ) 
AND YEAR( CURRENT_DATE( ) ) = YEAR( FROM_UNIXTIME(  `offer_history_time` ) ) 
GROUP BY DAY( FROM_UNIXTIME(  `offer_history_time` ) ) ")->result();
  }
  
  public function getTotalTokensWonPerOffer() {
    return $this->db->query("SELECT o.offer_name, SUM( o.offer_price ) AS tokens_won
FROM  `shp_offers_history` AS h
INNER JOIN shp_offers AS o ON o.offer_id = h.offer_id
GROUP BY h.offer_id
ORDER BY tokens_won DESC 
LIMIT 0 , 10")->result();
  }
  
  
  /*
   * All about categories
   */
  private $tableCategories = "shp_offers_categories";
  
  public function getAllCategories() {
    return $this->db->query("SELECT * FROM " . $this->tableCategories . ";")->result();
  }
  
  public function updateCategory($categoryData, $category_id) {
    $this->db->where("category_id", $category_id);
    $this->db->update($this->tableCategories, $categoryData);
  }

  public function createCategory($categoryData) {
    $this->db->insert($this->tableCategories, $categoryData);
  }
  
  public function deleteCategory($category_id) {
    $this->db->delete($this->tableCategories, array("category_id" => $category_id));
  }
  
  /*
   * All bout offer's element.
   */
  private $tableElements = "shp_offers_elements";
  private $elementTypeClass = array(1 => array("class" => "giveItemElement",
                                               "args" => "[Quantite];[Nom];[Id];(Meta-Id);(Enchantement);(EnchantementLvl)"),
                                    2 => array("class" => "iconomyMoneyElement",
                                               "args" => "[Argent]"),
                                    3 => array("class" => "groupManagerPromoteElement",
                                               "args" => "[NomGroupe]"),
                                    4 => array("class" => "giveXpElement",
                                               "args" => "[SommeXp]"),
                                    5 => array("class" => "executeCommandElement",
                                               "args" => "[Command];(Description)"),
                                    6 => array("class" => "executeSQLQueryElement",
                                               "args" => "[Query];(Description)"));
  
  public function getElementsByOfferId($offer_id) {
    $results = $this->db->query("SELECT * FROM " . $this->tableElements . " WHERE offer_id = ?", array($offer_id))->result_array();
    $arrayFinal = array();
    foreach($results AS $result) {
      $arrayFinal[] = $this->craftElement($result);
    }
    return $arrayFinal;
  }
 
  public function getElementById($element_id) {
    return $this->craftElement($this->db->query("SELECT * FROM " . $this->tableElements . " WHERE element_id = ?", array($element_id))->row_array());
  }
  
  public function getAllElementsTypes() {
    return $this->elementTypeClass;
  }
  
  public function craftElement($element_data) {
    $class = new ReflectionClass($this->elementTypeClass[$element_data["element_type"]]["class"]);
    $offer = $class->newInstanceArgs(array($element_data["element_id"], $element_data["element_type"], $element_data["offer_id"], explode(";", $element_data["element_args"])));
    return $offer;
  }
  
  public function updateElement($element_data, $element_id) {
    $this->db->where("element_id", $element_id);
    $this->db->update($this->tableElements, $element_data);
  }
  
  public function deleteElement($element_id) {
    $this->db->delete($this->tableElements, array("element_id" => $element_id));
  }
  
  public function createElement($dataElement) {
    $this->db->insert($this->tableElements, $dataElement);
  }
  
  private $tableOffersHistory = "shp_offers_history";
  
  public function addOfferHistory($offer_id, $time, $user_id, $price) {
    return $this->db->query("INSERT INTO " . $this->tableOffersHistory . "(offer_id, offer_history_time, user_id, offer_history_price) VALUES(?, ?, ?, ?)",
                                      array($offer_id, $time, $user_id, $price));
  }
  
  public function hasAlreadyBought($offer_id, $user_id) {
    return count($this->db->query("SELECT * FROM " . $this->tableOffersHistory . " WHERE user_id = ? AND offer_id = ?;", array($user_id, $offer_id))->result()) > 0;
  }
  
  private function getOffersHistory($rest, $data) {
    return $this->db->query("SELECT * FROM " . $this->tableOffersHistory . " " . $rest, $data);
  }
  
  public function getTransactionsHistoryOfUser($user_id) {
    return $this->getOffersHistory("WHERE user_id = ?", array($user_id))->result();
  }
}