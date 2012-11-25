<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Server_model extends CI_Model
{
  private $tableServers = "shp_servers";
  
  public function getAllServers() {
    return $this->db->query("SELECT * FROM " . $this->tableServers . ";")->result();
  }
  
  public function getServerById($server_id) {
    return $this->db->query("SELECT * FROM " . $this->tableServers . " WHERE server_id = ?", array($server_id))->row();
  }
  
  public function createServer($data) {
    return $this->db->insert($this->tableServers, $data);
  }
  
  public function updateServer($server_id, $data) {
    $this->db->where("server_id", $server_id);
    $this->db->update($this->tableServers, $data);
  }
  
  public function deleteServer($server_id) {
    $this->db->delete($this->tableServers, array("server_id" => $server_id));
  }
}