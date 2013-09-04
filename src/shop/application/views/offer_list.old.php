<h1>Boutique</h1>
<hr /><br />
<div>
<?php
$if_first = true;
foreach($categories_list AS $category) {
  ?>
  <span id="tab_div_<?php echo $category->category_id; ?>" class="tab_div <?php if ($if_first) { echo "tab_div_active"; } ?>" onClick="select_tab(<?php echo $category->category_id; ?>, <?php echo $category_id_js; ?>);">
    <?php echo $category->category_name; ?>
  </span>
  <?php
  $if_first = false;
}
?>
</div><br />
<?php
$if_first = true;
foreach($categories_list AS $category) {
  ?>
  <div id="offer_table_<?php echo $category->category_id; ?>" <?php if (!$if_first) { echo "style=\"display: none;\""; } ?>>
    <?php if (!empty($category->category_description)) { ?>
      <div class="category_description description">
        <?php echo $category->category_description; ?>
      </div>
    <?php } ?>
    <table class="datatable" style="width: 100%;">
      <tr>
        <th style="width: 200px;" class="headcell">Offre</th>
        <th class="headcell">Prix</th>
        <th style="width: 50px;" class="headcell">#</th>
      </tr>
      <?php
      foreach ($category->offers_list AS $offer) { ?>
        <tr>
          <td><?php echo $offer->offer_name; ?></td>
          <td><?php echo $offer->offer_price; ?> <img src="<?php echo base_url(); ?>img/coin.png">
            <?php if ($offer->offer_time_required > 0) { ?>(requiert <?php echo $offer->offer_time_required/(3600*24); ?> jours d'anciennetés)<?php } ?></td>
          <td><a class="button" href="<?php echo site_url("offer/show/" . $offer->offer_id); ?>">Voir</a></td>
        </tr>
        <?php
      }
      ?>
      
    </table>
  </div>
  <?php
  $if_first = false;
}
?>