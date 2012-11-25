<?php
global $globalConfig;
if ($this->usermanager->isAuthenticated())
  $userdata = $this->usermanager->getActualUserdata();
?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8" />
      <title>Boutique <?php echo $globalConfig["name_index_link"]; ?></title>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>style.css" media="screen" />
      <SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url(); ?>script.js"> </SCRIPT>
  </head>
  <body>
    <div class="navbar">
      <div class="sitebox" style="float:left;">
        <div class="name"><a style="color: inherit; decoration: none;" href="<?php echo $globalConfig["url_index_link"]; ?>"><?php echo $globalConfig["name_index_link"]; ?></a></div>
        <div class="links">
          <span class="elements"><a href="<?php echo site_url("accueil"); ?>">Accueil</a></span>
          <span class="elements"><a href="<?php echo site_url("offer"); ?>">Boutique</a></span>
          <span class="elements"><a href="<?php echo site_url("payement"); ?>">Créditer son compte</a></span>
          <?php foreach($globalConfig["links"] AS $link) {
            ?><span class="elements"><a href="<?php echo $link["url"]; ?>"><?php echo $link["name"]; ?></a></span><?php
          } ?>
          <?php if ($this->usermanager->isAuthenticated() && $userdata->user_is_admin) { ?>
            <span class="elements"><a style="color: #ec8383;" href="<?php echo site_url("admin"); ?>">Administration</a></span>
          <?php } ?>
        </div>
      </div>
      <div class="userbox" style="float: right;">
        <?php if ($this->usermanager->isAuthenticated()) {
          ?>
          <span class="hellomessage">Bonjour <a class="links" href="<?php echo site_url("user/profile/" . $userdata->user_name); ?>"><strong><?php echo $userdata->user_name; ?></strong></a></span> | 
		  <?php echo $userdata->user_count_tokens; ?> <img src="<?php echo base_url(); ?>img/coin.png"> | <a class="links" href="<?php echo site_url("user/deco"); ?>">Déconnexion</a>
          <?php
        } else { ?>
          <a class="links" href="<?php echo site_url("user/authenticate"); ?>">Se connecter</a> | <a class="links" href="<?php echo site_url("user/register"); ?>">S'inscrire</a>
          <?php
        }
        ?>
      </div>
    </div>
    <div class="logo element">
      <img src="<?php echo $globalConfig["logo_url"]; ?>" />
    </div>
    <div class="body element">
      <?php echo $include; ?>
    </div>
  </body>
</html>

