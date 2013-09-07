<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Version_model extends CI_Model
{
  private $url = "http://192.95.11.149/Mineshop/";

  public function getNextVersionData($version = "") {
    if ($version == "") {
      $version = $this->getActualVersion();
    }
    $result = @file_get_contents($this->url . "get_next_version.php?version=" . $version);
    if ($result === FALSE)
        return "SERVER_DOWN";
    $dataResult = explode(" ", $result);
    return $dataResult;
    
  }
  
  public function getChangelog($version) {
    $result = file_get_contents($this->url . $version . "/changelog.txt");
    $resultArray = explode(CHR(10), $result);
    return $resultArray;
  }
  
  public function getActualVersion() {
    return file_get_contents("version.txt");
  }
  
  public function getDownloadLink($version) {
    return $this->url . $version . "/Mineshop.zip";
  }
  
  public function hasADatabaseScript($version) {
    return (file_get_contents($this->url . $version . "/database_script.sql") !== false);
  }
  
  public function applyDatabaseScript($version) {
    $allRequests = file_get_contents($this->url . $version . "/database_script.sql");
    foreach(explode(CHR(10), $allRequests) AS $request) {
      $this->db->query($request);
    }
  }
}