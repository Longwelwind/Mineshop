<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PayementPaypal extends PayementType
{
  private $CI;
  private $dataAPI;

  public function __construct($data) {
    parent::__construct($data);
    $this->CI = get_instance();
    $this->dataAPI = explode("/", $data["payement_args"]);
  }
  
  /**
   * 0=>Somme
   * 1=>UserAPI
   * 2=>Mot de passe API
   * 3=>SignatureAPI
   */
  
  public function getPrice() {
    return $this->price;
  }
  
  public function displayPayementPage($user_id) {
    $url_paypal = $this->buildBaseRequest();
    // On ecrit la commande de l'URL
    $requete = $url_paypal."&METHOD=SetExpressCheckout".
			"&CANCELURL=".urlencode(site_url("payement/problem/" . $this->payement_id)).
			"&RETURNURL=".urlencode(site_url("payement/callback_paypal/" . $this->payement_id)).
			"&CURRENCYCODE=EUR".
      "&AMT=".urlencode($this->dataAPI[0]).
      //"&ITEMAMT=".urlencode($this->dataAPI[0]).
			"&DESC=".urlencode("Paypal " . $this->payement_token_reward . " tokens").
      /*"&L_PAYMENTREQUEST_0_AMT0=".urlencode($this->dataAPI[0]).
      "&L_PAYMENTREQUEST_0_DESC0=".urlencode("Paypal " . $this->payement_token_reward . " tokens").
      "&L_PAYMENTREQUEST_0_NAME0=".urlencode("Test").
      "&L_PAYMENTREQUEST_0_QTY0=1".*/
			"&LOCALECODE=FR".
			//"&HDRIMG=".urlencode("http://www.siteduzero.com/Templates/images/designs/2/logo_sdz_fr.png").
      "";
    // Initialise notre session cURL. On lui donne la requête à exécuter
    $ch = curl_init($requete);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $resultat_paypal = curl_exec($ch);

    if (!$resultat_paypal)
      {echo "<p>Erreur</p><p>".curl_error($ch)."</p>";}
    else
    {
      $liste_parametres = explode("&",$resultat_paypal); // Crée un tableau de paramètres
      foreach($liste_parametres as $param_paypal) // Pour chaque paramètre
      {
        list($nom, $valeur) = explode("=", $param_paypal); // Sépare le nom et la valeur
        $liste_param_paypal[$nom]=urldecode($valeur); // Crée l'array final
      }

      // Si la requête a été traitée avec succès
      if ($liste_param_paypal['ACK'] == 'Success')
      {
        // Redirige le visiteur sur le site de PayPal
        ?>Vous êtes sur le point d'acheter <?php echo $this->payement_token_reward; ?> tokens pour <?php echo $this->dataAPI[0]; ?>€. Pour continuer l'achat, rendez-vous sur ce lien: <a href="https://www.paypal.com/webscr&cmd=_express-checkout&token=<?php echo $liste_param_paypal['TOKEN']; ?>">Payer</a><?php
      }
      else // En cas d'échec, affiche la première erreur trouvée.
      {echo "<p>Erreur de communication avec le serveur PayPal.<br />".$liste_param_paypal['L_SHORTMESSAGE0']."<br />".$liste_param_paypal['L_LONGMESSAGE0']."</p>";}		
    }
    curl_close($ch);
  }
  
  public function buildBaseRequest() {
    $api_paypal = 'https://api-3t.paypal.com/nvp?'; // Site de l'API PayPal. On ajoute déjà le ? afin de concaténer directement les paramètres.
    $version = 94.0; // Version de l'API
   
    $user = $this->dataAPI[1]; // Utilisateur API
    $pass = $this->dataAPI[2]; // Mot de passe API
    $signature = $this->dataAPI[3]; // Signature de l'API

    $url_paypal = $api_paypal.'VERSION='.$version.'&USER='.$user.'&PWD='.$pass.'&SIGNATURE='.$signature; // Ajoute tous les paramètres
    return $url_paypal;
  }
  
  public function getDataAPI() {
    return $this->dataAPI;
  }
}