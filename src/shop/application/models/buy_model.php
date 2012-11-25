<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Offer_model extends CI_Model
{
  private $tableOffers = "shp_offers";
  
  public function getAllOffers() {
    return $this->getOffers()->result();
  }
  
  private function getOffers($rest = "", $array = array()) {
    return $this->db->query("SELECT * FROM " . $this->tableOffers . " " . $rest, $array);
  }
  
  public function getOfferById($offer_id) {
    return $this->getOffers("WHERE offer_id = ?", array($offer_id))->row();
  }
  
  /*
   * All bout offer's element.
   */
  private $tableElements = "shp_offers_elements";
   
   public function getElementsByOfferId($offer_id) {
     return $this->db->query("SELECT * FROM " . $this->tableElements . " WHERE offer_id = ?", array($offer_id))->result();
   }
}