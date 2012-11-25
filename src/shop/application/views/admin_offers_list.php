<h1>Gestion des offres</h1>
<hr />
<?php
if (isset($goodError)) { ?>
  <div class="gooderrorbox returnbox"><span><?php echo $goodError; ?></span></div>
  <?php
}
?>
<div>
<?php
foreach($categoriesList as $category) {
  ?>
  <div>
    <form method="post" action="<?php echo site_url("admin/update_category/" . $category->category_id); ?>">
      <h2><?php echo $category->category_name; ?></h2>
      <strong>Description:</strong><br />
      <textarea rows="7" cols="80" name="category_description"><?php echo $category->category_description; ?></textarea><br />
      <input class="button" type="submit">
    </form>
    <form method="post" onSubmit="return (confirm('Êtes vous-sur de vouloir supprimer cette catégorie (Ainsi que toutes les offres qui y sont contenue) ?'))" action="<?php echo site_url("admin/delete_category"); ?>"><input type="hidden" name="category_id" value="<?php echo $category->category_id; ?>"><input class="button" type="submit" value="Supprimer"></form>
    
    <table class="datatable">
      <tr>
        <th>Nom de l'offre</th>
        <th>Prix</th>
        <th>Ancienneté req</th>
        <th>Offre requise</th>
        <th>Catégorie</th>
        <th>Unique <img src="<?php echo base_url(); ?>img/help.png" onmouseover="tooltip.show('Une offre unique ne peut être acheté qu\'une et une seule fois.', 300);" onmouseout="tooltip.hide();"></th>
        <th>Ordre <img src="<?php echo base_url(); ?>img/help.png" onmouseover="tooltip.show('Vous permet de modifier l\'ordre d\'affichage des ordres dans la boutique. Les offres sont affichés dans un ordre croissant selon leur Ordre.', 300);" onmouseout="tooltip.hide();"></th>
        <th>#</th>
        <th>#</th>
        <th>#</th>
      </tr>
      <?php
      foreach ($category->elements AS $offer) { ?>
        <form method="post" action="">
          <tr>
            <td><input name="offer_name" style="width: 150px;" value="<?php echo $offer->offer_name; ?>"></td>
            <td><input name="offer_price" style="width: 25px;" value="<?php echo $offer->offer_price; ?>">
				<img src="<?php echo base_url(); ?>img/coin.png"></td>
            <td><input style="width: 80px;" name="offer_time_required" value="<?php echo $offer->offer_time_required; ?>"></td>
            <td>
              <select style="width: 150px;" name="offer_offer_required">
                <option value="0">Aucun</option>
                <?php
                  foreach($allOffers AS $offerBis) {
                    ?><option <?php if ($offerBis->offer_id == $offer->offer_offer_required) {?>selected<?php } ?> value="<?php echo $offerBis->offer_id; ?>"><?php echo $offerBis->offer_name; ?></option><?php
                  }
                ?>
              </select>
            </td>
            <td>
              <select name="offer_category_id">
                <?php
                  foreach($categoriesList AS $categoryBis) {
                    ?><option <?php if ($categoryBis->category_id == $offer->offer_category_id) {?>selected<?php } ?> value="<?php echo $categoryBis->category_id; ?>"><?php echo $categoryBis->category_name; ?></option><?php
                  }
                ?>
              </select>
            </td>
            <td><input type="hidden" name="offer_is_unique_present" value="1"><input type="checkbox" name="offer_is_unique" <?php if ($offer->offer_is_unique) { ?>checked<?php } ?>></td>
            <td><input name="offer_order" style="width: 30px;" value="<?php echo $offer->offer_order; ?>"></td>
			<td><input type="hidden" name="offer_id" value="<?php echo $offer->offer_id; ?>"><input class="button" type="submit"></td>
          </form>
            <td><form onSubmit="return (confirm('Êtes vous-sur de vouloir supprimer cette offre ?'))" action="<?php echo site_url("admin/delete_offer"); ?>" method="post"><input type="hidden" name="offer_id" value="<?php echo $offer->offer_id; ?>"><input class="button" value="Supprimer" type="submit"></form></a></td>
            <td><a class="button" href="<?php echo site_url("admin/elements_list/" . $offer->offer_id); ?>">Voir</a></td>
          </tr>
        <?php
      }
      ?>
    </table>
  </div>
  <?php
}
?>
</div>
<hr />
<table style="width: 100%;">
  <tr style="vertical-align: top;">
    <td style="width: 50%;">
      <div class="box" >
        <div class="box_title">Ajouter une catégorie</div>
        <form method="post" action="<?php echo site_url("admin/create_category"); ?>">
            <table>
            <tr><td class="leftcellule">Nom:</td><td><input name="category_name"></td></tr>
            <tr><td class="leftcellule">Description:</td><td><textarea rows="7" cols="40" name="category_description"></textarea></td></tr>
            <tr><td></td><td><input class="button" type="submit"></td></tr>
            </table>
        </form>
      </div>
    </td>
    <td>
      <div class="box">
        <form method="post" action="<?php echo site_url("admin/create_offer"); ?>">
          <div class="box_title">Créer une offre:</div>
            <table>
              <tr><td class="leftcellule">Nom: </td><td><input name="offer_name"></td></tr>
              <tr><td class="leftcellule">Prix: </td><td><input style="width: 40px;" name="offer_price"> <img src="<?php echo base_url(); ?>img/coin.png"></td></tr>
              <tr><td class="leftcellule">Catégorie:</td>
                <td>
                  <select name="offer_category_id">
                          <?php
                            foreach($categoriesList AS $categoryBis) {
                              ?><option value="<?php echo $categoryBis->category_id; ?>"><?php echo $categoryBis->category_name; ?></option><?php
                            }
                          ?>
                  </select>
                </td>
              </tr>
              <tr><td class="leftcellule">Offre requise:</td>
                <td>
                  <select name="offer_offer_required">
                          <option value="0">Aucun</option>
                          <?php
                            foreach($allOffers AS $offerBis) {
                              ?><option value="<?php echo $offerBis->offer_id; ?>"><?php echo $offerBis->offer_name; ?></option><?php
                            }
                          ?>
                  </select>
                </td>
              </tr>
              <tr><td class="leftcellule">Unique</td><td><input type="checkbox" name="offer_is_unique"></td></tr>
              <tr><td class="leftcellule"></td><td><input class="button" type="submit"></td></tr>
            </table>
        </form>
      </div>
    </td>
  </tr>
</table>