<?php
class Accueil extends CI_Controller
{
  public function index() {
    global $globalConfig;
    $this->data["globalConfig"] = $globalConfig;
    $this->layout->view("accueil", $this->data);
  }
  
  public function install() {
  }
}