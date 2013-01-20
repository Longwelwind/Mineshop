<?php
class Payement extends CI_Controller
{
  private $data = array();

  public function __construct() {
    parent::__construct();
    $this->load->model("payement_model");
    if (!$this->usermanager->isAuthenticated()) {
      redirect("accueil");
    }
  }
  
	public function index() {
		$this->list_payement();
	}
  
  public function list_payement() {
    $this->data["list_payements"] = array();
    foreach($this->payement_model->getPayementTypes() AS $key => $type) {
      $type["payements"] = $this->payement_model->getPayementsByType($key);
      $this->data["list_payements"][] = $type;
    }
    $this->layout->view("payement_list", $this->data);
  }
  
  public function problem($payement_id) {
    $this->data["payement"] = $this->payement_model->getPayementById($payement_id);
    $this->layout->view("payement_problem", $this->data);
  }
  
  public function valid($payement_id) {
    $this->data["payement"] = $this->payement_model->getPayementById($payement_id);
    $this->layout->view("payement_valid", $this->data);
  }
  
  public function pay($id_offer) {
    $this->data["payement"] = $this->payement_model->getPayementById($id_offer);
    $this->layout->view("payement_pay", $this->data);
  }
  
  public function callback_allopass($type_id = 0) {
    $payementOffer = $this->payement_model->getPayementById($type_id);
    $CODE = $_GET["RECALL"];
    if (trim($CODE) == "") {
      $this->problem($type_id);
      return;
    }
    $CODERECALL = urlencode($CODE);
    $AUTH = urlencode(implode("/", $payementOffer->getDataAPI()));
  
    $r = @file("http://payment.allopass.com/api/checkcode.apu?code=" . $CODERECALL . "&auth=" . $AUTH);
    if( substr( $r[0],0,2 ) != "OK" ) 
    {
      $this->problem($type_id);
      return;
    }
    // C'est bon ! Code accepté !
    // On ajoute les tokens
    if ($this->payement_model->isNewTransaction($payementOffer->payement_id, $CODERECALL)) {
      $userdata = $this->usermanager->getActualUserdata();
      $userdata->user_count_tokens += $payementOffer->payement_token_reward; 
      $this->usermanager->setUserdata($userdata, $userdata->user_id);
      // On log le code et la transaction
      $this->payement_model->addTransactionHistory($CODERECALL, $userdata->user_id, $type_id, time());
      $this->valid($type_id);
    } else {
      $this->problem($type_id);
    }
  }
  
  public function callback_rentabiliweb($type_id = 0) {
    $payementOffer = $this->payement_model->getPayementById($type_id);
    // Identifiants de votre document
    $dataAPI = $payementOffer->getDataAPI();
    $docId = $dataAPI[1];
    $siteId = $dataAPI[0];
    // PHP5 avec register_long_arrays désactivé?
    if (!isset($HTTP_GET_VARS)) {
      $HTTP_SERVER_VARS = $_SERVER;
      $HTTP_GET_VARS = $_GET;
      // Construction de la requête pour vérifier le code
      $query = 'http://payment.rentabiliweb.com/checkcode.php?';
      $query .= 'docId='.$docId;
      $query .= '&siteId='.$siteId;
      $query .= '&code='.$HTTP_GET_VARS['code'];
      $query .= "&REMOTE_ADDR=".$HTTP_SERVER_VARS['REMOTE_ADDR'];
      $result = @file($query);
      if(trim($result[0]) == "OK") {
        // On execute le tout !
        if ($this->payement_model->isNewTransaction($payementOffer->payement_id, $HTTP_GET_VARS['code'])) {
            $userdata = $this->usermanager->getActualUserdata();
            $userdata->user_count_tokens += $payementOffer->payement_token_reward;
            $this->usermanager->setUserdata($userdata, $userdata->user_id);
            // On log le code et la transaction
            $this->payement_model->addTransactionHistory($HTTP_GET_VARS['code'], $userdata->user_id, $type_id, time());
            $this->valid($type_id);
        } else {
            $this->problem($type_id);
        }
      }
    }
  }
  
  public function callback_starpass($type_id = 0) {
    
    if(isset($_POST['DATAS'])) $datas = $_POST['DATAS'];
    // Le champ data contient L'id de l'offre
    $type_id = $datas;
    $payementOffer = $this->payement_model->getPayementById($datas);
    // Déclaration des variables
    $ident=$idp=$ids=$idd=$codes=$code1=$code2=$code3=$code4=$code5=$datas='';
    $dataAPI = $payementOffer->getDataAPI();
    $idp = $dataAPI[0];
    // $ids n'est plus utilisé, mais il faut conserver la variable pour une question de compatibilité
    $idd = $dataAPI[1];
    $ident=$idp.";".$ids.";".$idd;
    // On récupère le(s) code(s) sous la forme 'xxxxxxxx;xxxxxxxx'
    if(isset($_POST['code1'])) $code1 = $_POST['code1'];
    if(isset($_POST['code2'])) $code2 = ";".$_POST['code2'];
    if(isset($_POST['code3'])) $code3 = ";".$_POST['code3'];
    if(isset($_POST['code4'])) $code4 = ";".$_POST['code4'];
    if(isset($_POST['code5'])) $code5 = ";".$_POST['code5'];
    $codes=$code1.$code2.$code3.$code4.$code5;
    // On récupère le champ DATAS
    
    // On encode les trois chaines en URL
    $ident=urlencode($ident);
    $codes=urlencode($codes);
    $datas=urlencode($datas);
    
    /* Envoi de la requête vers le serveur StarPass
    Dans la variable tab[0] on récupère la réponse du serveur
    Dans la variable tab[1] on récupère l'URL d'accès ou d'erreur suivant la réponse du serveur */
    $get_f=@file("http://script.starpass.fr/check_php.php?ident=" . $ident . "&codes=" . $codes . "&DATAS=" . $datas);
    if(!$get_f)
    {
    exit("Votre serveur n'a pas accès au serveur de Starpass, merci de contacter votre hébergeur.");
    }
    //var_dump();
    $tab = explode("|",$get_f[0]);
    if(!isset($tab[1])) {
      $url = "http://script.starpass.fr/erreur.php";
    }
    else {
      $url = $tab[1];
      // dans $pays on a le pays de l'offre. exemple "fr"
      $pays = $tab[2];
      // dans $palier on a le palier de l'offre. exemple "Plus A"
      $palier = urldecode($tab[3]);
      // dans $id_palier on a l'identifiant de l'offre
      $id_palier = urldecode($tab[4]);
      // dans $type on a le type de l'offre. exemple "sms", "audiotel, "cb", etc.
      $type = urldecode($tab[5]);
      // vous pouvez à tout moment consulter la liste des paliers à l'adresse : http://script.starpass.fr/palier.php

      
      // Si $tab[0] ne répond pas "OUI" l'accès est refusé
      // On redirige sur l'URL d'erreur
    }

    
    if(substr($tab[0],0,3) != "OUI")
    {
      $this->problem($type_id);
    }
    else
    {
          if ($this->payement_model->isNewTransaction($payementOffer->payement_id, $code1)) {
            $userdata = $this->usermanager->getActualUserdata();
            $userdata->user_count_tokens += $payementOffer->payement_token_reward;
            $this->usermanager->setUserdata($userdata, $userdata->user_id);
            // On log le code et la transaction
            $this->payement_model->addTransactionHistory($code1, $userdata->user_id, $type_id, time());
            $this->valid($type_id);
          } else {
            $this->problem($type_id);
          }

          // vous pouvez afficher les variables de cette façon :
          // echo "idd : $idd / codes : $codes / datas : $datas / pays : $pays / palier : $palier / id_palier : $id_palier / type : $type";
    }
  }
  
  public function callback_paypal($type_id = 0) {
    $payementOffer = $this->payement_model->getPayementById($type_id);
    $dataAPI = $payementOffer->getDataAPI();
    $url_paypal = $payementOffer->buildBaseRequest();
    //echo 4 . $_SERVER["REQUEST_URI"];
    if (!isset($_GET["token"])) {
      $token = preg_replace("/(.*)token=([^&?]*)(.*)/", "$2", $_SERVER["REQUEST_URI"]);
    } else {
      $token = $_GET['token'];
    }
    if (!isset($_GET["PayerID"])) {
      $PayerID = preg_replace("/(.*)PayerID=([^&?]*)(.*)/", "$2", $_SERVER["REQUEST_URI"]);
    } else {
      $PayerID = $_GET['PayerID'];
    }
    $requete = $url_paypal."&METHOD=DoExpressCheckoutPayment".
			"&TOKEN=".htmlentities($token, ENT_QUOTES). // Ajoute le jeton qui nous a été renvoyé
			"&AMT=".$dataAPI[0].
			"&CURRENCYCODE=EUR".
			"&PayerID=".htmlentities($PayerID, ENT_QUOTES). // Ajoute l'identifiant du paiement qui nous a également été renvoyé
			"&PAYMENTACTION=sale";
    $ch = curl_init($requete);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resultat_paypal = curl_exec($ch);
    if (!$resultat_paypal) // S'il y a une erreur
    {
      $this->problem($type_id);
    }
    // S'il s'est exécuté correctement
    else
    {
      $liste_parametres = explode("&",$resultat_paypal); // Crée un tableau de paramètres
      foreach($liste_parametres as $param_paypal) // Pour chaque paramètre
      {
        list($nom, $valeur) = explode("=", $param_paypal); // Sépare le nom et la valeur
        $liste_param_paypal[$nom]=urldecode($valeur); // Crée l'array final
      }
      
      // Si la requête a été traitée avec succès
      if ($liste_param_paypal['ACK'] == "Success") {
        // Mise à jour de la base de données & traitements divers... Exemple :
        if ($this->payement_model->isNewTransaction($payementOffer->payement_id, $token)) {
            $userdata = $this->usermanager->getActualUserdata();
            $userdata->user_count_tokens += $payementOffer->payement_token_reward;
            $this->usermanager->setUserdata($userdata, $userdata->user_id);
            // On log le code et la transaction
            $this->payement_model->addTransactionHistory($token, $userdata->user_id, $type_id, time());
            $this->valid($type_id);
          } else {
            $this->problem($type_id);
          }
      } else {
        $this->problem($type_id);
      }
    }
    curl_close($ch);
  }
}

?>