<h1>Installer la version <?php echo $version; ?></h1>
<hr />
<?php
if (isset($goodError)) { ?>
  <div class="gooderrorbox returnbox"><span><?php echo $goodError; ?></span></div>
  <?php
}
?>

<div style="width: 48%;float: left;"; class="box">
  <div class="box_title">Changelog</div><br />
  <ul>
  <?php foreach ($changelog as $change) {
    ?>
    <li><?php echo $change; ?></li>
    <?php
  } ?>
  </ul>
</div>
<div style="width: 47%;float: left;margin-left: 5px;"; class="box">
  <div class="box_title">Comment installer une nouvelle version</div><br />
  <p style="margin-top: 0px;">Premièrement, vous devez appliquer, si il y en a un, un script de modification de base
  de données. Si il y a un bouton <strong>[Appliquer un script de base de données]</strong> ci-dessous, appuyez sur celui-ci
  et attendez que Mineshop applique ce script.</p>
  <p>Une fois ceci fait, vous pouvez télécharger la nouvelle version de Mineshop via le bouton ci-dessous,
  et envoyer tout le contenu de l'archive sur votre serveur FTP en séléctionnant l'option "Écrasez" si on
  vous le demande. Faites toujours, avant d'installer une nouvelle version, un back-up de l'installation actuelle
  au cas où un problème serait survenu durant l'installation.</p>
</div><br />
<div style="text-align: right;" >
  <?php if ($this->version_model->hasADatabaseScript($version)) {
    ?><a class="button" href="<?php echo site_url("admin/apply_script/" . $version); ?>">
      Appliquer le script Sql
    </a><?php
  }
  ?>
  <a class="button" href="<?php echo $this->version_model->getDownloadLink($version); ?>">Télécharger</a>
</div>