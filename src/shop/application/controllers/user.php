<?php

class User extends CI_Controller
{
  private $data = array();

	public function index() {
    
		if ($this->usermanager->isAuthenticated()) {
      $this->profile();
    } else {
      $this->authenticate();
    }
	}
  
  public function authenticate() {
    if ($this->usermanager->isAuthenticated()) {
      $this->profile();
      return;
    }
  
    if ($this->input->post("nickname") || $this->input->post("password")) {
      $name = $this->input->post("nickname");
      $password = $this->input->post("password");
      if ($this->usermanager->authenticate($name, md5($password))) {
        $this->data["goodError"] = "Bienvenue <strong>" . $name . "</strong> !";
        $this->profile();
        return;
      } else {
        $this->data["error"] = "Mauvais identifiant/mot de passe.";
      }
    }
    $this->layout->view("user_authenticate", $this->data);
  }
  
  public function register() {
    if ($this->input->post("nickname") && $this->input->post("password") && $this->input->post("passwordBis") && $this->input->post("email")) {
      if ($this->input->post("password") == $this->input->post("passwordBis")) {
        $nickname = $this->input->post("nickname");
        $password = $this->input->post("password");
        $email = $this->input->post("email");
        if (is_numeric(($result = $this->usermanager->register($nickname, $password, $email)))) {
          // Enregistrement réussi.
          // Si c'était l'Id 1, on le nomme admin
          if ($result == 1) {
            $this->usermanager->setUserdata(array("user_is_admin" => 1), $result);
          }
          
          $this->data["goodError"] = "Vous vous êtes correctement enregsitré, vous pouvez désormais vous connecter !";
          $this->authenticate();
          return;
        } else {
          $this->data["error"] = $result;
        }
      } else {
        $this->data["error"] = "Les 2 mots de passes ne correspondent pas.";
      }
    }
    
    $this->layout->view("user_register", $this->data);
  }
  
  public function deco() {
    $this->usermanager->deconnection();
    $this->authenticate();
  }
  
  public function profile($nickname = ""){
    if (!$this->usermanager->isAuthenticated()) {
      $this->authenticate();
      return;
    }
    $this->load->model("offer_model");
    if ($nickname != "") {
      $this->data["userProfile"] = $this->usermanager->getUserByNickname($nickname);
      if (!$this->data["userProfile"]) {
        $this->layout->view("user_profile_error");
        return;
      }
    } else {
      $this->data["userProfile"] = $this->usermanager->getActualUserdata();
      
    }
    $userdata = $this->data["userProfile"];
    $this->data["userProfile"]->transactionsHistory = $this->offer_model->getTransactionsHistoryOfUser($userdata->user_id);
    $this->layout->view("user_profile", $this->data);
  }
}

?>