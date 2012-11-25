<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Layout
{
	private $data = array();
  private $template = "template/template.php";
  private $CI;
	
	public function __construct() {
		$this->CI =& get_instance();
	}
	
	public function view($page, $data = array()) {
    $realData = array_merge($this->data, $data);
    $realData["include"] = $this->CI->load->view($page, $realData, true);
    $this->CI->load->view($this->template, $realData);
	}
  
  public function splash($page, $data = array()) {
    $this->CI->load->view("splash/" + $page, $data);
  }
}