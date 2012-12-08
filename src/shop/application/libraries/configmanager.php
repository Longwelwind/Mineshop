<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ConfigManager
{
	private $table = "shp_config";
	private $CI;
  
	public function __construct() {
		$this->CI =& get_instance();
	}
  
  public function getConfig($key) {
    $query = $this->CI->db->query("SELECT value FROM " . $this->table . " WHERE name = ?;", array($key));
    if ($query->num_rows() > 0)
      return $query->row()->value;
    else {
      // On retourne rien
      return "";
    }
  }
  
  public function setConfig($key, $value) {
    $query = $this->CI->db->query("SELECT value FROM " . $this->table . " WHERE name = ?;", array($key));
    if ($query->num_rows() > 0)
      $this->CI->db->query("UPDATE " . $this->table . " SET value = ? WHERE name = ?;", array($value, $key));
    else
      $this->CI->db->query("INSERT INTO " . $this->table . "(name, value) VALUES(?, ?)", array($key, $value));
  }
}