<?php
require("serverlink.php");

class Offer extends CI_Controller
{
  private $data = array();

  public function __construct() {
    parent::__construct();
    $this->load->model("offer_model");
    if (!$this->usermanager->isAuthenticated()) {
      redirect("user/authenticate");
    }
    $this->data["userdata"] = $this->usermanager->getActualUserdata();
  }
  
	public function index() {
    $this->list_offers();
	}
  
  public function list_offers() {
    $this->data["categories_list"] = $this->offer_model->getAllCategories();
    $listIdCatego = array();
    foreach($this->data["categories_list"] AS $category) {
      $listIdCatego[] = $category->category_id;
      $category->offers_list = $this->offer_model->getOffersByCategoryId($category->category_id);
    }
    // We generate a alist of all the category's id and we create javascript code
    $this->data["category_id_js"] = "[" . implode(", ", $listIdCatego) . "]";
    $this->data["offers_list"] = $this->offer_model->getAllOffers();
  
		$this->layout->view("offer_list", $this->data);
  }
  
  public function show($offer_id) {
    $this->data["offer"] = $this->offer_model->getOfferById($offer_id);
    $offer = $this->data["offer"];
    $userdata = $this->data["userdata"];
    if ($this->data["offer"] !== FALSE) {
      $this->data["offer"]->elements = $this->offer_model->getElementsByOfferId($offer_id);
      //var_dump($this->data["offer"]->elements);
      // On regarde pour le bouton ACHETER
      if ($userdata->user_count_tokens < $offer->offer_price) {
        $this->data["errorPay"] = "Vous n'avez pas assez de tokens.";
      } else if ($offer->offer_time_required > 0 && (time() - $userdata->user_register_time) < $offer->offer_time_required) {
        $this->data["errorPay"] = "Vous devez avoir " . $offer->offer_time_required / (60*60*24) . " d'ancienneté pour acheter cette offre.";
      } else if ($offer->offer_offer_required > 0 && !$this->offer_model->hasAlreadyBought($offer->offer_offer_required, $userdata->user_id)) {
        $offerRequired = $this->offer_model->getOfferById($offer->offer_offer_required);
        $this->data["errorPay"] = "Vous devez d'abord acquérir l'offre \"" . $offerRequired->offer_name . "\" avant de pouvoir acheter celle-ci.";
      }
      $this->layout->view("offer_show", $this->data);
    }
  }
  
  public function buy($offer_id) {
    $this->data["offer"] = $this->offer_model->getOfferById($offer_id);
    $offer = $this->data["offer"];
    if ($this->data["offer"]) {
      $this->data["offer"]->elements = $this->offer_model->getElementsByOfferId($offer_id);
      // On regarde si il a assez de thune
      $userdata = $this->usermanager->getActualUserdata();
      if ($userdata->user_count_tokens >= $offer->offer_price) {
        // On regarde si on à affaire à une offre unique
        if (($offer->offer_is_unique && !$this->offer_model->hasAlreadyBought($offer->offer_id, $userdata->user_id)) || (!$offer->offer_is_unique)) {
          // On regarde pour une limite d', et on doit aussi regarder si il peut "payer avec le temps"
          if (($offer->offer_time_required > 0 && (time() - $userdata->user_register_time) > $offer->offer_time_required) ||
              ($offer->offer_time_required == 0)) {
            if (($offer->offer_offer_required > 0 && $this->offer_model->hasAlreadyBought($offer->offer_offer_required, $userdata->user_id)) ||
                ($offer->offer_offer_required == 0)) {
              // On procède à l'achat:
              // On active les elements:
              // On doit le faire pour tous les serveurs, $servers vient du fichier de config globale
              $this->load->model("server_model");
              $results = $this->server_model->getAllServers();
              $allConnectionsAccepted = true;
              $serversWebsend = array();
              foreach ($results AS $server) {
                if ($server->server_active == 1) {
                  $websend = new ServerLink();
                  $serversWebsend[] = $websend;
                  //echo $websend->PHPconnect($server->server_host, $server->server_password, $server->server_port);
                  if ($websend->connect($server->server_host, $server->server_password, $server->server_port) > 0) {
                    $allConnectionsAccepted = false;
                  }
                }
              }
              
              if ($allConnectionsAccepted) {
                foreach($serversWebsend AS $websend) {
                  foreach($this->data["offer"]->elements AS $element) {
                    $element->complete($websend, $this->usermanager->getActualUserdata());
                  }
                  $websend->disconnect();
                }
                // On débite l'argent
                $userdata->user_count_tokens = $userdata->user_count_tokens - $offer->offer_price;
                $this->usermanager->setUserdata($userdata, $userdata->user_id);
                // On log l'achat dans l'historique
                $this->offer_model->addOfferHistory($offer->offer_id, time(), $userdata->user_id, $offer->offer_price);
                $this->data["goodError"] = "Vous avez acheté \"" . $offer->offer_name . "\" pour " . $offer->offer_price . " tokens.";
              } else {
                $this->data["error"] = "Une erreur est survenu durant l'achat, veuillez réessayez plus tard.";
              }
              
            } else {
              $this->data["error"] = "Vous devez d'abord acheter une offre avant de pouvoir acquérir celles-ci.";
            }
          } else {
           $this->data["error"] = "Vous n'êtes pas assez ancien pour acheter cet offre.";
          }
        } else {
          $this->data["error"] = "Vous avez déjà achetez cette offre (Elle est unique)";
        }
      } else {
        $this->data["error"] = "Vous n'avez pas assez de tokens.";
      }
      $this->show($offer_id);
    }
  }
}

?>