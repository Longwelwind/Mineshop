<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PayementStarpass extends PayementType
{
  private $CI;
  private $dataAPI;

  public function __construct($data) {
    parent::__construct($data);
    $this->CI = get_instance();
    $this->dataAPI = explode("/", $data["payement_args"]);
  }
  
  public function displayPayementPage($user) {
    ?>
    <div id="starpass_<?php echo $this->dataAPI[1]; ?>"></div>
    <script type="text/javascript" src="http://script.starpass.fr/script.php?idd=<?php echo $this->dataAPI[1]; ?>&amp;verif_en_php=1&amp;datas=<?php echo $user->user_id; ?>">
    </script>
    <noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
    <a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
    </noscript>
    <?php
  }
  
  public function getDataAPI() {
    return $this->dataAPI;
  }
}