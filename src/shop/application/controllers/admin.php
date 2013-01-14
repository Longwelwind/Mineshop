<?php
require("serverlink.php");

class Admin extends CI_Controller
{
  public function __construct() {
    parent::__construct();
    $this->data["userdata"] = $this->usermanager->getActualUserdata();
    if (!$this->usermanager->isAuthenticated() || !$this->data["userdata"]->user_is_admin) {
      redirect("user/authenticate");
    }
  }

  public function index() {
    $this->load->model("version_model");
    $this->data["next_version"] = $this->version_model->getNextVersionData();
    $this->data["data"] = array(array("label" => "Gérer les utilisateurs",
                                      "link" => site_url("admin/users_list")),
                                array("label" => "Gérer les offres",
                                      "link" => site_url("admin/offers_list")),
                                array("label" => "Gérer les serveurs",
                                      "link" => site_url("admin/servers_list")),
                                array("label" => "Gérer les payements",
                                      "link" => site_url("admin/payements_list")),
                                array("label" => "Statistiques",
                                      "link" => site_url("admin/stats")),
                                array("label" => "Configuration",
                                      "link" => site_url("admin/configuration")));
    $this->layout->view("admin_index", $this->data);
  }
  
  public function users_list($nickname = "") {
    if ($this->input->post("searchName"))
      $nickname = $this->input->post("searchName");
    $this->data["usersList"] = $this->usermanager->searchUsersByNickname($nickname);
    $this->layout->view("admin_users_list", $this->data);
  }
  
  public function payements_list() {
    $this->load->model("payement_model");
    $this->data["payementsList"] = $this->payement_model->getAllPayements();
    $this->data["payementTypes"] = $this->payement_model->getPayementTypes();
    $this->data["payementsTypesStringJs"] = array();
    foreach($this->data["payementTypes"] AS $type) {
        $this->data["payementTypesStringJs"][] = $type["class"] . ": '" . $type["args"] . "'";
    }
    $this->layout->view("admin_payements_list", $this->data);
  }
  
  public function create_payement() {
    $this->load->model("payement_model");
    if ($this->input->post("payement_name")) {
      $dataCat = $_POST;
      
      $newId = $this->payement_model->createPayement($dataCat);
      $this->data["goodError"] = "Offre de payement crée (Id: " . $newId . ") !";
    }
    $this->payements_list();
  }
  
  public function delete_payement() {
    $this->load->model("payement_model");
    if ($this->input->post("payement_id")) {
      $this->payement_model->deletePayement($this->input->post("payement_id"));
      $this->data["goodError"] = "Offre de payement supprimée !";
    }
    $this->payements_list();
  }
  
  public function update_payement($payement_id) {
    $this->load->model("payement_model");
    if ($this->input->post("payement_name")) {
      $this->payement_model->updatePayement($payement_id, $_POST);
      $this->data["goodError"] = "Modification effectuée !";
    }
    $this->payements_list();
  }
  
  public function user_update($user_id) {
    if ($this->input->post("user_name")) {
      if (!$this->input->post("user_is_admin"))
        $_POST["user_is_admin"] = false;
      else
        $_POST["user_is_admin"] = true;
      $this->usermanager->setUserdata($_POST, $user_id);
      $this->data["goodError"] = "Modification effectuée !";
    }
    $this->users_list();
  }
  
  public function update_category($category_id) {
    $this->load->model("offer_model");
    if ($this->input->post("category_description")) {
      $this->offer_model->updateCategory($_POST, $category_id);
      $this->data["goodError"] = "Catégorie modifiée !";
    }
    $this->offers_list();
  }
  
  public function create_category() {
    $this->load->model("offer_model");
    if ($this->input->post("category_name")) {
      $dataCat = $_POST;
      
      $this->offer_model->createCategory($dataCat);
      $this->data["goodError"] = "Categoriée crée !";
    }
    $this->offers_list();
  }
  public function create_offer() {
    $this->load->model("offer_model");
    if ($this->input->post("offer_name")) {
      $dataCat = $_POST;
      if (!$this->input->post("offer_is_unique"))
        $_POST["offer_is_unique"] = false;
      else
        $_POST["offer_is_unique"] = true;
      $this->offer_model->createOffer($dataCat);
      $this->data["goodError"] = "Offre crée !";
    }
    $this->offers_list();
  }
  
  public function update_offer($offer_id) {
    $this->load->model("offer_model");
    $dataArray = $_POST;
    if ($this->input->post("offer_is_unique_present")) {
      if ($this->input->post("offer_is_unique"))
        $dataArray["offer_is_unique"] = true;
      else
        $dataArray["offer_is_unique"] = false;
      unset($dataArray["offer_is_unique_present"]);
    }
    $this->offer_model->updateOffer($dataArray, $offer_id);
    $this->data["goodError"] = "Offre modifiée !";
  }
  
  public function update_element($element_id) {
    $this->load->model("offer_model");
    if ($this->input->post("element_type")) {
      $this->offer_model->updateElement($_POST, $element_id);
      $this->data["goodError"] = "Element d'offre modifié !";
    }
    $element = $this->offer_model->getElementById($element_id);
    $this->elements_list($element->getOfferId());
  }
  
  public function delete_offer() {
  $this->load->model("offer_model");
    if ($this->input->post("offer_id")) {
      $this->offer_model->deleteOffer($this->input->post("offer_id"));
      $this->data["goodError"] = "Offre supprimée !";
    }
    $this->offers_list();
  }
 
  public function delete_category() {
    $this->load->model("offer_model");
    if ($this->input->post("category_id")) {
      $this->offer_model->deleteCategory($this->input->post("category_id"));
      $this->data["goodError"] = "Catégorie supprimée !";
    }
    $this->offers_list();
  }
  
  public function offers_list() {
    $this->load->model("offer_model");
    if ($this->input->post("offer_id")) {
      $this->update_offer($this->input->post("offer_id"));
    }
    $this->data["categoriesList"] = $this->offer_model->getAllCategories();
    $this->data["allOffers"] = $this->offer_model->getAllOffers();
    foreach($this->data["categoriesList"] AS $category) {
      $category->elements = $this->offer_model->getOffersByCategoryId($category->category_id);
    }
    $this->layout->view("admin_offers_list", $this->data);
  }
  
  public function elements_list($offer_id) {
    $this->load->model("offer_model");
    if ($this->input->post("offer_id") && $this->input->post("offer_description")) {
      $this->update_offer($this->input->post("offer_id"));
    }
    $this->data["allElements"] = $this->offer_model->getElementsByOfferId($offer_id);
    $this->data["offer"] = $this->offer_model->getOfferById($offer_id);
    $this->data["allTypesElement"] = $this->offer_model->getAllElementsTypes();
    $trans = array();
    foreach($this->data["allTypesElement"] AS $type) {
      $trans[] = $type["class"] . ": " . $type["args"];
    }
    $this->data["typesElementStringJs"] = implode(", ", $trans);
    $this->layout->view("admin_elements_list", $this->data);
  }
  
  public function delete_element($offer_id) {
    $this->load->model("offer_model");
    if ($this->input->post("element_id")) {
      $this->offer_model->deleteElement($this->input->post("element_id"));
      $this->data["goodError"] = "Element supprimée !";
    }
    $this->elements_list($offer_id);
  }
  
  public function create_element($offer_id) {
    $this->load->model("offer_model");
    if ($this->input->post("element_type")) {
      $dataCat = $_POST;
      $this->offer_model->createElement($dataCat);
      $this->data["goodError"] = "Element crée !";
    }
    $this->elements_list($offer_id);
  }
  
  public function servers_list($test_connection = 0) {
    $this->load->model("server_model");
    $this->data["listServers"] = $this->server_model->getAllServers();
    // On essaie la connection sur tous les serveurs et on leur ajoute une propriété "is_connected"
    foreach ($this->data["listServers"] AS &$server) {
      $websend = new ServerLink();
      if ($test_connection == 1) {
        $server->is_connected = ($websend->connect($server->server_host, $server->server_password, $server->server_port) == 0);
        $websend->disconnect();
      }
      
    }
    $this->data["test_connection"] = $test_connection;
    $this->layout->view("admin_servers_list", $this->data);
  }
  
  public function create_server() {
    $this->load->model("server_model");
    if ($this->input->post("server_name")) {
      $data = $_POST;
      $this->server_model->createServer($data);
      $this->data["goodError"] = "Server ajouté !";
    }
    $this->servers_list();
  }
  
  public function update_server($server_id) {
    $this->load->model("server_model");
    if ($this->input->post("server_name")) {
      $data = $_POST;
      if (isset($_POST["server_active"]))
        $data["server_active"] = 1;
      else
        $data["server_active"] = 0;
      $this->server_model->updateServer($server_id, $data);
      $this->data["goodError"] = "Server modifié !";
    }
    
    $this->servers_list();
  }
  
  public function delete_server() {
    $this->load->model("server_model");
    if ($this->input->post("server_id")) {
      $this->server_model->deleteServer($this->input->post("server_id"));
      $this->data["goodError"] = "Server retiré !";
    }
    $this->servers_list();
  }
  
  public function script($server_id = 0) {
    $this->load->model("server_model");
    if ($server_id != 0) {
      $server = $this->server_model->getServerById($server_id);
      $category_id = 1;
      // On prend toutes les transactions qui se sont deroulés dans les offres dont la catégorie vaut 
      $result = $this->db->query("SELECT * 
FROM  `shp_offers_history` AS h
INNER JOIN  `shp_offers` AS o ON h.offer_id = o.offer_id
WHERE o.offer_category_id =?", array($category_id))->result();
      // On établit la connection avec le serveur
      $websend = new PHPsend();
      if ($websend->PHPconnect($server->server_host, $server->server_password, $server->server_port) == 0) {
        // On rééxecute chaque commande sur le serveur ciblé
        foreach($result AS $commande) {
          //$element->complete($websend, $this->usermanager->getUserdataById($commande->user_id));
        }
        $websend->PHPdisconnect();
        ?>C'est fait bro (<?php echo count($result); ?> commandes executées) !<?php
      } else {
        ?>Impossible de se connecter au serveur<?php
      }
    } else {
      ?>Serveur inconnu<?php
    }
  }
  
  public function version($version) {
    $this->load->model("version_model");
    $this->data["version"] = $version;
    // On va chercher le change-log et le formater an array.
    $this->data["changelog"] = $this->version_model->getChangelog($version);
    $this->layout->view("admin_version_show", $this->data);
  }
  
  public function apply_script($version) {
    $this->load->model("version_model");
    $this->version_model->applyDatabaseScript($version);
    $this->data["goodError"] = "Script appliqué !";
    $this->version($version);
  }
  
  public function configuration() {
  
    if (isset($_POST["shop_title"])) {
      // On fait la liste des clés _POST qu'on accepte
      $acceptedKeys = array("shop_title", "shop_title_link", "shop_logo", "home_page");
      $datas = simple_filter_array($acceptedKeys, $_POST);
      //var_dump($datas);
      foreach ($datas AS $keyData => $keyValue) {
        $this->configmanager->setConfig($keyData, $keyValue);
      }
      $this->data["goodError"] = "Configuration modifié !";
    }
    $this->layout->view("admin_config", $this->data);
  }
  
  public function stats() {
  $this->load->model("offer_model");
  $this->load->model("payement_model");
  ini_set('display_errors', 1); 
  ini_set('log_errors', 1); 
  ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); 
  error_reporting(E_ALL);
	// On donne la liste des offres qui ont rapportés
  $this->data["offers_list"] = $this->offer_model->getTotalTokensWonPerOffer();
  $this->data["payements_list"] = $this->payement_model->getTotalUsedPerPayement();
	$MyData = new pData();
	// On crée un tableau de l'argent gagné par jour depuis le début du mois
	$tokensPerMonth = array(); 
	foreach ($this->offer_model->getAmountTokensByDayForActualMonth() AS $entry) {
		$tokensPerMonth[] = $entry->sum_tokens;
	}
	$MyData->addPoints($tokensPerMonth,"Tokens");
	$MyData->setAxisName(0,"Tokens");
	// On crée un tableau qui donne tous les jours du mois en s'arrêtant au maximum
	$dayOfMonth = array();
	for ($i = 1;$i <= 31;$i++) {
		$dayOfMonth[] = $i;
	}
	$MyData->addPoints($dayOfMonth,"Day");
	//$MyData->setSerieDescription("Labels","Months");
	$MyData->setAbscissa("Day");


	 /* Create the pChart object */
	 $myPicture = new pImage(1000,230,$MyData);

	 /* Turn of Antialiasing */
	 $myPicture->Antialias = FALSE;

	 /* Add a border to the picture */
	 $myPicture->drawRectangle(0,0,999,229,array("R"=>0,"G"=>0,"B"=>0));
	 
	 /* Write the chart title */ 
	 $myPicture->setFontProperties(array("FontName"=>"application/libraries/nolibraries/pChart/fonts/verdana.ttf","FontSize"=>8));
	 $myPicture->drawText(150,35,"Total tokens utilisés",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

	 /* Set the default font */

	 /* Define the chart area */
	 $myPicture->setGraphArea(60,40,970,200);

	 /* Draw the scale */
	 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
	 $myPicture->drawScale($scaleSettings);

	 /* Turn on Antialiasing */
	 $myPicture->Antialias = TRUE;

	 /* Draw the line chart */
	 $config = array("DisplayValues" => 1);
	 $myPicture->drawLineChart($config);

	 /* Write the chart legend */
	 $myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
	 $myPicture->Render("img/global_chart.png");
	
	$this->layout->view("admin_stats", $this->data);
  }
}