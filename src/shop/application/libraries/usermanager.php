<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Usermanager
{
	private $tableUser = "shp_users";
	
	public function __construct() {
		$this->CI =& get_instance();
	}
  
  public function isAuthenticated() {
    return $this->CI->session->userdata("user_id") !== FALSE;
  }
  
  public function register($nickname, $password, $email) {
    if (!$this->getUserByNickname($nickname)) {
      if (!$this->getUserByEmail($email)) {
        if (preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#", $email)) {
          if ($this->CI->db->query("INSERT INTO " . $this->tableUser . "(user_name, user_password, user_email, user_register_time) VALUES(?, ?, ?, ?)",
              array($nickname, md5($password), $email, time()))) {  
            return $this->CI->db->insert_id();
          } else {
            return "Un problème est survenu durant l'inscription. Veuillez réessayez.";
          }
        } else {
          return "Le format d'E-mail n'est pas respecté.";
        }
      } else {
        return "Cet e-mail est déjà utilisé.";
      }
    } else {
      return "Ce pseudo est déjà utilisé. (Si vous pensez que l'on vous a pris votre pseudo Minecraft, contactez le support [ici])";
    }
  }
  
  public function deconnection() {
    $this->CI->session->unset_userdata("user_id");
  }
  
  public function authenticate($name, $pw) {
    $user = $this->getUserByNicknameAndPassword($name, $pw);
    if (!empty($user)) {
      $this->CI->session->set_userdata("user_id", $user->user_id);
      return true;
    }
    return false;
  }
  
  public function searchUsersByNickname($nickname, $limit = "0", $limitBis = "30") {
    return $this->CI->db->query("SELECT * FROM " . $this->tableUser . " WHERE user_name LIKE \"%" . $this->CI->db->escape_str($nickname) . "%\" LIMIT " . $limit . ", " . $limitBis . ";")->result();
  }
  
  public function getUserByNickname($nickname) {
    return $this->CI->db->query("SELECT * FROM " . $this->tableUser . " WHERE user_name = ?;", array($nickname))->row();
  }
  
  public function getUserByNicknameAndPassword($name, $pw) {
    return $this->CI->db->query("SELECT * FROM " . $this->tableUser . " WHERE user_name = ? AND user_password = ?;", array($name, $pw))->row();
  }
  
  public function getUserByEmail($email) {
    return $this->CI->db->query("SELECT * FROM " . $this->tableUser . " WHERE user_email = ?;", array($email))->row();
  }
  
  public function getUserdataById($id) {
    return $this->CI->db->query("SELECT * FROM " . $this->tableUser . " WHERE user_id = ?;", array($id))->row();
  }
  
  public function getActualUserId() {
    return $this->CI->session->userdata("user_id");
  }
  
  public function getActualUserdata() {
    return $this->getUserdataById($this->getActualUserId());
  }
  
  public function setUserdata($userdata, $id) {
    $this->CI->db->where("user_id", $id);
    $this->CI->db->update($this->tableUser, $userdata);
  }
}