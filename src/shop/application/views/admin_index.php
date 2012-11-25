<h1>Administration</h1>
<hr />
<?php
if ($next_version[0] == "LAST_VERSION") {
  ?><div class="gooderrorbox returnbox">
    Vous utilisez la dernière version de Mineshop !
  </div><?php
} else if ($next_version[0] == "NEW_VERSION" && $next_version[2] == 1) {
  ?><div class="errorbox returnbox">
    Hurray ! Mineshop <strong>v<?php echo $next_version[1]; ?></strong> est sortie ! Mettez vous à jour le plus vite.<br />
    <a href="<?php echo site_url("admin/version/" . $next_version[1]); ?>">Installez la v<?php echo $next_version[1]; ?></a>
  </div><?php
} else if ($next_version[0] == "NEW_VERSION" && $next_version[2] > 1) {
  ?><div class="errorbox returnbox">
    Naméoh ! Vous avez <strong><?php echo $next_version[2]; ?></strong> versions en retard,
    la dernière version sortie est là <strong>v<?php echo $next_version[3]; ?></strong>, la prochaine
    à installer est la <strong>v<?php echo $next_version[1]; ?></strong> !<br />
    <a href="<?php echo site_url("admin/version/" . $next_version[1]); ?>">Installez la v<?php echo $next_version[1]; ?></a>
  </div><?php
} else if ($next_version[0] == "UNKNOWN_VERSION") {
  ?><div class="errorbox returnbox">
    Dafuq, vous utilisez une version non-officielle de MineShop.
  </div><?php
}
?>

Bonjour !<br />
Le panel d'administration vous permet de gérer la boutique, des tutoriaux pour administrer tous les éléments sont disponibles ici:
<a href="http://ptibiscuit.pulseheberg.org/wiki/index.php?title=Mineshop">http://ptibiscuit.pulseheberg.org/wiki/index.php?title=Mineshop</a>
<div style="text-align: center;">
<?php
foreach($data AS $entry) {
  ?>
  <a href="<?php echo $entry["link"]; ?>"><div class="admin_big_button"><?php echo $entry["label"]; ?></div></a>
  <?php
}
?>
</div>
<div>
	<i>Vous utilisez la version <strong>v<?php include("version.txt"); ?></strong> de MineShop</i>
</div>