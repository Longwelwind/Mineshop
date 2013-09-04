<h1>Inscription</h1>
<hr />
<?php if (isset($error)) {
  ?><div class="errorbox returnbox"><span><?php echo $error; ?></span></div><?php
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
      <tr>
        <td class="leftcellule"><img style="border: 1px grey solid;padding: 2px;border-radius: 4px 4px;" id="captcha" src="<?php echo base_url(); ?>libraries/securimage/securimage_show.php" alt="CAPTCHA Image" /></td>
        <td>Écrivez ce que vous voyez:<br />
            <input type="text" name="captcha_code" size="10" maxlength="6" /><br />
            <a style="font-size: 10px;" href="#" onclick="document.getElementById('captcha').src = '<?php echo base_url(); ?>libraries/securimage/securimage_show.php?' + Math.random(); return false">
            Autre image ?
            </a>
        </td>
      </tr>
    <tr><td></td><td><input type="submit"></td></tr>
  </form>
</div>