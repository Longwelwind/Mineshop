<h1>Description de l'offre "<?php echo $offer->offer_name; ?>"</h1>
<hr />
<?php
if (isset($goodError)) { ?>
  <div class="gooderrorbox returnbox"><span><?php echo $goodError; ?></span></div>
  <?php
}
?>
<?php
if (isset($error)) { ?>
  <div class="errorbox returnbox"><span><?php echo $error; ?></span></div>
  <?php
}
?>
<?php if (!empty($offer->offer_description)) { ?>
      <div class="category_description description">
        <?php echo $offer->offer_description; ?>
      </div>
<?php } ?>
<strong>Prix:</strong> <?php echo $offer->offer_price; ?> <img src="<?php echo base_url(); ?>img/coin.png"><br />
<div class="box" style="width: 40%;">
  <div class="box_title">Contient:</div><br />
  <table class="datatable" style="width: 400px;">
  <tr><th>Element</th></tr>
  <?php foreach ($offer->elements AS $element) { ?>
    <tr><td><?php echo $element->getExplainString(); ?></td></tr>
    <?php
  }
  ?>
  </table>
</div>
<div style="height: 25px;">
<?php if (isset($errorPay)) { ?>
  <?php echo $errorPay; ?>
<?php } else { ?>
  <a class="buy_button button" href="<?php echo site_url("offer/buy/" . $offer->offer_id); ?>">ACHETER</a>
<?php } ?>
</div>