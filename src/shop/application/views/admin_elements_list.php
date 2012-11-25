<h1>Gestion de l'offre "<?php echo $offer->offer_name; ?>"</h1>
<hr />
<script type="text/javascript">
var elementTypes = array {
  <?php echo $allTypesElement; ?>
};
</script>
<?php
if (isset($goodError)) { ?>
  <div class="gooderrorbox returnbox"><span><?php echo $goodError; ?></span></div>
  <?php
}
?>
<table style="width: 98%;">
  <tr>
    <td>
      <div class="box">
        <div class="box_title">Caractéristiques:</div>
        <form method="post" action="">
          <strong>Description:</strong><br />
          <textarea rows="5" cols="55" name="offer_description"><?php echo $offer->offer_description; ?></textarea><br />
          <input type="hidden" name="offer_id" value="<?php echo $offer->offer_id; ?>"><input type="submit" />
        </form>
      </div>
    </td>
    <td style="vertical-align: top;">
      <div class="box" style="width: 100%;">
        <div class="box_title">Ajouter un élément</div>
        <form method="post" action="<?php echo site_url("admin/create_element/" . $offer->offer_id); ?>">
            <table>
              <tr>
                <td class="leftcellule">Type d'élément</td>
                <td>
                  <select name="element_type">
                      <?php
                      foreach($allTypesElement AS $elementTypeId => $elementType) {
                        ?><option value="<?php echo $elementTypeId; ?>"><?php echo $elementType["class"]; ?></option><?php
                      }
                      ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td class="leftcellule">Args</td><td><input name="element_args"></td>
              </tr>
              <tr>
                <td><input type="hidden" name="offer_id" value="<?php echo $offer->offer_id; ?>"></td><td><input type="submit" class="button"></td>
              </tr>
            </table>
        </form>
      </div>
    </td>
  </tr>
</table>
  <table class="datatable">
    <tr>
      <th>Type</th>
      <th>Args requis</th>
      <th>Args</th>
      <th>#</th>
      <th>#</th>
    </tr>
  <?php
  foreach ($allElements AS $element) {
    ?>
    <tr>
      <form action="<?php echo site_url("admin/update_element/" . $element->getId()); ?>" method="POST">
        <td>
          <select name="element_type">
            <?php
            foreach($allTypesElement AS $elementTypeId => $elementType) {
             ?><option <?php if ($element->getTypeId() == $elementTypeId) {?>selected<?php } ?> value="<?php echo $elementTypeId; ?>"><?php echo $elementType["class"]; ?></option><?php
           }
           ?>
          </select>
        </td>
        <td></td>
        <td><input name="element_args" value="<?php echo implode(";", $element->getData()); ?>"></td>
        <td><input class="button" type="submit"></td>
      </form>
      <td>
        <form method="post" onSubmit="return (confirm('Êtes vous-sur de vouloir supprimer cette élément ?'))" action="<?php echo site_url("admin/delete_element/" . $offer->offer_id); ?>">
          <input type="hidden" name="element_id" value="<?php echo $element->getId(); ?>">
          <input class="button" type="submit" value="Supprimer">
        </form>
      </td>
    </tr>
    <?php
  }
  ?>
  </table>