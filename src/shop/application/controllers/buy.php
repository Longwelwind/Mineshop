<?php
class Buy extends CI_Controller
{
  private $data = array();

	public function index() {
		$this->layout->view("buy_list", $this->data);
	}
}

?>