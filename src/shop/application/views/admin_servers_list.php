<h1>Gestion des serveurs</h1>
<hr />
<?php
if (isset($goodError)) { ?>
  <div class="gooderrorbox returnbox"><span><?php echo $goodError; ?></span></div>
  <?php
}
?>
<a href="<?php echo site_url("admin/servers_list/1"); ?>">Tester les connections</a> <img src="<?php echo base_url(); ?>img/help.png" onmouseover="tooltip.show('Ceci vous permet d\'essayer les connections que vous avez enregistrés. Il y aura un [F] (échec) ou un [V] (succès) vous indiquant le résultat.<br/>Si, après, il vous est impossible d\'accéder à la page, ou qu\'elle prend trop longtemps à se charger, c\'est que vos Id de connection (Probablement votre \'adresse\' est fausse.)', 300);" onmouseout="tooltip.hide();"><br />
<table class="datatable">
  <tr>
    <th>Name</th>
    <th>Adresse</th>
    <th>Port</th>
    <th>Password</th>
    <?php if ($test_connection == 1) { ?>
      <th>Test</th>
    <?php } ?>
    <th>Actif</th>
    <th>#</th>
    <th>#</th>
  </tr>
  <?php
  foreach($listServers AS $server) {
    ?>
    <tr>
      <form method="post" action="<?php echo site_url("admin/update_server/" . $server->server_id); ?>">
        <td><input name="server_name" value="<?php echo $server->server_name; ?>"></td>
        <td><input name="server_host" value="<?php echo $server->server_host; ?>"></td>
        <td><input name="server_port" value="<?php echo $server->server_port; ?>"></td>
        <td><input name="server_password" value="<?php echo $server->server_password; ?>"></td>
        <?php if ($test_connection == 1) { ?>
          <td>
            <?php if ($server->is_connected) { ?>
              [V]
            <?php } else { ?>
              [F]
            <?php } ?>
          </td>
        <?php } ?>
        <td><input type="checkbox" <?php if ($server->server_active) { ?>checked<?php } ?> name="server_active" class="button"></td>
        <td><input type="submit" class="button" value="Modifier"></td>
      </form>
        <td>
          <form method="post" onSubmit="return (confirm('Êtes vous-sur de vouloir retirer ce serveur ?'))" action="<?php echo site_url("admin/delete_server"); ?>">
            <input type="hidden" name="server_id" value="<?php echo $server->server_id; ?>">
            <input class="button" type="submit" value="Supprimer">
          </form>
        </td>
    </tr>
    <?php
  }
  ?>
</table>
<div class="box" style="width: 45%;">
  <div class="box_title">Ajouter un serveur</div>
  <form action="<?php echo site_url("admin/create_server"); ?>" method="post">
      <table>
        <tr>
          <td class="leftcellule">Nom:</td><td><input name="server_name"></td>
        </tr>
        <tr>
          <td class="leftcellule">Adresse:</td><td><input name="server_host"></td>
        </tr>
        <tr>
          <td class="leftcellule">Port:</td><td><input name="server_port"></td>
        </tr>
        <tr>
          <td class="leftcellule">Mot de passe:</td><td><input type="password" name="server_password"></td>
        </tr>
        <tr>
          <td></td><td><input type="submit" class="button"></td>
        </tr>
      </table>
  </form>
</div>