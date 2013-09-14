<?php
include("phpsend.php");
include("jsonapi.php");

class ServerLink {
  public $phpsend;
  public $jsonapi;

  public function __construct() {
    //$this->phpsend = new PHPsend();
    // Does nothing
  }
  
  public function connect($host, $mdp, $port) {
    //return $this->phpsend->PHPconnect($host, $mdp, $port);
    $this->jsonapi = new JSONAPI($host, $port, "mineshop", $mdp, "salt");
    $result = $this->jsonapi->call("getPlayerLimit");
    if ($result != NULL) {
      return 0;
    } else {
      return 1;
    }
  }
  
  public function command($command) {
    //return $this->phpsend->PHPcommand($command);
    $i = $this->jsonapi->call("runConsoleCommand", array($command));
    return $i;
  }
  
  public function disconnect() {
    //return $this->phpsend->PHPdisconnect();
    // Does nothing
  }
}
