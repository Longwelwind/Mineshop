<script type="text/javascript">
var payementTypes = {
  <?php echo implode(", ", $payementTypesStringJs); ?>
};
</script>
<h1>Gestion des payements</h1>
<hr />
<?php
if (isset($goodError)) { ?>
  <div class="gooderrorbox returnbox"><span><?php echo $goodError; ?></span></div>
  <?php
}
?>
<form method="post" action="">
  
</form>
<table class="datatable">
  <tr>
    <th>Nom</th>
    <th>Type</th>
    <th>Args requis</th>
    <th>Args</th>
    <th>Tokens donné</th>
    <th>#</th>
    <th>#</th>
  </tr>
<?php
foreach ($payementsList AS $payement) {
  ?>
  <tr>
    <form name="payement_update" action="<?php echo site_url("admin/update_payement/" . $payement->payement_id); ?>" method="POST">
      <td><input name="payement_name" value="<?php echo $payement->payement_name; ?>"></td>
      <td>
        <select name="payement_type" id="payement_type_<?php echo $payement->payement_id; ?>" onChange="display_args_template('args_template_help_<?php echo $payement->payement_id; ?>', 'payement_type_<?php echo $payement->payement_id; ?>')">
          <?php
          foreach($payementTypes AS $typeId => $type) {
           ?><option <?php if ($payement->payement_type == $typeId) {?>selected<?php } ?> value="<?php echo $typeId; ?>"><?php echo $type["class"]; ?></option><?php
          }
          ?>
        </select>
      </td>
      <td id="args_template_help_<?php echo $payement->payement_id; ?>" ></td>
        <script type="text/javascript">display_args_payement_template('args_template_help_<?php echo $payement->payement_id; ?>', 'payement_type_<?php echo $payement->payement_id; ?>');</script>
      <td><input name="payement_args" value="<?php echo $payement->payement_args; ?>"></td>
      <td><input name="payement_token_reward" style="width: 40px;" value="<?php echo $payement->payement_token_reward; ?>"> <img src="<?php echo base_url(); ?>img/coin.png"></td>
      <td><input class="button" type="submit"></td>
    </form>
    <td>
      <form method="post" onSubmit="return (confirm('Êtes vous-sur de vouloir supprimer ce payement ?'))" action="<?php echo site_url("admin/delete_payement/"); ?>">
        <input type="hidden" name="payement_id" value="<?php echo $payement->payement_id; ?>">
        <input class="button" type="submit" value="Supprimer">
      </form>
    </td>
  </tr>
  <?php
}
?>
</table>
<div class="box" style="width: 45%;">
  <form method="post" action="<?php echo site_url("admin/create_payement/"); ?>">
    <div class="box_title">Ajouter un payement:</div>
      <table>
        <tr><td class="leftcellule">Nom:</td><td><input name="payement_name"></td></tr>
        <tr>
          <td class="leftcellule">Type de payement</td>
          <td>
            <select id="payement_type" onChange="display_args_payement_template('payement_type', 'args_template_help')" name="payement_type">
                <?php
                foreach($payementTypes AS $typeId => $type) {
                 ?><option value="<?php echo $typeId; ?>"><?php echo $type["class"]; ?></option><?php
                }
                ?>
            </select>
          </td>
        </tr>
        <tr>
          <td class="leftcellule">Model d'args</td><td id="args_template_help">#</td>
        </tr>
          <script type="text/javascript">display_args_payement_template('args_template_help', 'payement_type');</script>
        <tr>
          <td class="leftcellule">Args</td><td><input name="payement_args"></td>
        </tr>
        <tr><td class="leftcellule">Tokens donné:</td><td><input name="payement_token_reward"></td></tr>
        <tr>
          <td></td><td><input type="submit" class="button"></td>
        </tr>
      </table>
  </form>
</div>