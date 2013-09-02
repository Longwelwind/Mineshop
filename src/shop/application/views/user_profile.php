<h1>Profil de <?php echo htmlspecialchars($userProfile->user_name); ?></h1>
<hr>
<?php
date_default_timezone_set("Europe/Berlin");
if (isset($goodError)) { ?>
  <div class="gooderrorbox returnbox"><span><?php echo $goodError; ?></span></div>
  <?php
}
?>
<div class="box">
  <div class="box_title">Historique des transactions</div><br />
  <table class="datatable">
  <tr>
    <th class="headcell">Date d'achat</th>
    <th class="headcell">Dépense</th>
    <th class="headcell">Achat</th>
  </tr>
  <?php
  if (count($userProfile->transactionsHistory) > 0) {
    foreach($userProfile->transactionsHistory AS $transaction) {
      // On fait rapidos le truc pour avoir l'offre choisie
      $offer = $this->offer_model->getOfferById($transaction->offer_id);
      ?>
      <tr>
        <td><?php echo date("G:i à j/n/Y", $transaction->offer_history_time); ?></td>
        <td><?php echo $transaction->offer_history_price; ?> tokens</td>
        <td><?php echo $offer->offer_name; ?></td>
      </tr>
      <?php
    }
  } else {
    ?>
    <tr>
        <td class="cell_mid_text" colspan="3">Aucune transaction</td>
      </tr>
    <?php
  }
  ?>
  </table>
</div>