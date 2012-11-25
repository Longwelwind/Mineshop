<h1>Se connecter à la boutique</h1>
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

<div>
  <form method="POST">
    <table class="tableform">
      <tr>
        <td class="leftcellule">Pseudo:</td><td><input type="text" name="nickname"></td>
      </tr>
      <tr>
        <td class="leftcellule">Mot de passe:</td><td><input type="password" name="password"></td>
      </tr>
    <tr><td></td><td><input type="submit"></td></tr>
  </form>
</div>