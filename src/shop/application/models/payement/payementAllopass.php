<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PayementAllopass extends PayementType
{
  private $CI;
  private $dataAPI;

  public function __construct($data) {
    parent::__construct($data);
    $this->CI = get_instance();
    $this->dataAPI = explode("/", $data["payement_args"]);
  }
  
  public function displayPayementPage($user_id) {
    ?>
    <script type="text/javascript" src="https://payment.allopass.com/buy/checkout.apu?ids=<?php echo $this->dataAPI[0]; ?>&idd=<?php echo $this->dataAPI[1]; ?>&lang=fr"></script>
    <noscript>
     <a href="https://payment.allopass.com/buy/buy.apu?ids=<?php echo $this->dataAPI[0]; ?>&idd=<?php echo $this->dataAPI[1]; ?>" style="border:0">
      <img src="https://payment.allopass.com/static/buy/button/fr/162x56.png" style="border:0" alt="Buy now!" />
     </a>
    </noscript>
    <?php
  }
  
  public function getDataAPI() {
    return $this->dataAPI;
  }
}