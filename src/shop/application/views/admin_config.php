<h1>Configuration</h1>
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
<form method="POST">
  <div>
    Titre de la boutique
    <img src="<?php echo base_url(); ?>img/help.png"onmouseover="tooltip.show('C\'est ce qui est affiché en haut à gauche du site', 300);" onmouseout="tooltip.hide();"><br />
    <input name="shop_title" value="<?php echo $this->configmanager->getConfig("shop_title"); ?>" /><br />
    Lien vers votre site
    <img src="<?php echo base_url(); ?>img/help.png"onmouseover="tooltip.show('C\'est le lien vers lequel va rediriger le titre en haut à gauche', 300);" onmouseout="tooltip.hide();"><br />
    <input name="shop_title_link" value="<?php echo $this->configmanager->getConfig("shop_title_link"); ?>" ><br />
    Logo affiché en haut à gauche<br />
    <input name="shop_logo" value="<?php echo $this->configmanager->getConfig("shop_logo"); ?>"><br />
    Message d'accueil<br />
    <textarea name="home_page" rows="10" cols="90"><?php echo $this->configmanager->getConfig("home_page"); ?></textarea><br />
  </div>
  <div>
  <div>
    
  </div>
  
  <input class="button" type="submit">
</form>