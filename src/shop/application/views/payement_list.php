<h1>Acheter des tokens</h1>
<hr />
<?php
foreach ($list_payements AS $type) {
  if (count($type["payements"]) > 0) {
    ?>
    <div>
      <div>
        <h2 style="display: inline;"><?php echo $type["name"]; ?></h2> <em><?php echo $type["description"]; ?></em>
      </div>
      <?php
      foreach ($type["payements"] AS $payement) {
        ?>
        <div style="float: left; margin: 5px;">
          <?php ?>
          <a href="<?php echo site_url("payement/pay/" . $payement->payement_id . "/"); ?>"><?php echo $payement->payement_name; ?></a><br/>
            Pour: <?php echo $payement->payement_token_reward; ?> <img src="<?php echo base_url(); ?>img/coin.png">
        </div>
        <?php
      }
      ?>
    </div><br /><br /><br /><br /><br /><br />
    <?php
  }
}
?>