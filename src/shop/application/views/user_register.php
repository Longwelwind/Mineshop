<h1>Inscription</h1>
<hr />
<?php if (isset($error)) {
  ?><div><?php echo $error; ?></div><?php
}?>
<div>
  <form method="POST">
    <table class="tableform">
      <tr>
        <td class="leftcellule">Pseudo :</td><td><input type="text" name="nickname"> <img src="<?php echo base_url(); ?>img/help.png" onmouseover="tooltip.show('Vous devez entrer votre pseudo Minecraft.net, celui que vous utilisez pour vous connecter a votre compte Minecraft.', 300);" onmouseout="tooltip.hide();"></td>
      </tr>
      <tr>
        <td class="leftcellule">Mot de passe:</td><td><input type="password" name="password"> 
        <img src="<?php echo base_url(); ?>img/help.png" onmouseover="tooltip.show('Votre mot de passe ne doit pas forcément être celui de Minecraft.net. Nous vous conseillons d\'ailleurs d\'utiliser un mot de passe différent.', 300);" onmouseout="tooltip.hide();">
        </td>
      </tr>
      <tr>
        <td class="leftcellule">Confirmation du mot de passe:</td><td><input type="password" name="passwordBis"></td>
      </tr>
      <tr>
        <td class="leftcellule">Email:</td><td><input name="email"></td>
      </tr>
    <tr><td></td><td><input type="submit"></td></tr>
  </form>
</div>