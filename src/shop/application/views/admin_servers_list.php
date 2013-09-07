<h3>Gestion des serveurs</h3>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Liste des serveurs</h3>
            </div>
            <div class="panel-body">
                <a class="btn btn-info pull-right" style="margin-bottom: 15px;" href="<?php echo site_url("admin/servers_list/1"); ?>">Tester les connections</a>
                
                <table class="table table-bordered table-stripped table-condensed">
                    <tr>
                        <th>Nom</th>
                        <th width="230px">Adresse</th>
                        <th width="190px">Port</th>
                        <th width="230px">Mot de passe</th>
                        <th width="10px">Actif</th>
                        <th width="87px"></th>
                        <th width="102px"></th>
                    </tr>
                    <?php foreach($listServers AS $server) { ?>
                        <tr class="<?php if ($test_connection == 1) { if ($server->is_connected) { ?>success<?php } else { ?>danger<?php } } ?>">
                            <form method="post" action="<?php echo site_url("admin/update_server/" . $server->server_id) ?>" >
                                <td><input class="form-control" name="server_name" value="<?php echo $server->server_name; ?>"></td>
                                <td><input class="form-control" name="server_host" value="<?php echo $server->server_host; ?>"></td>
                                <td><input class="form-control" name="server_port" value="<?php echo $server->server_port; ?>"></td>
                                <td><input class="form-control" name="server_password" value="<?php echo $server->server_password; ?>"></td>
                                <td align="center"><input type="checkbox" <?php if ($server->server_active) { ?>checked<?php } ?> name="server_active" class="checkbox"></td>
                                <td><input type="submit" class="btn btn-default" value="Modifier"></td>
                            </form>
                                <td>
                                    <form method="post" onSubmit="return (confirm('Êtes vous-sur de vouloir retirer ce serveur ?'))" action="<?php echo site_url("admin/delete_server"); ?>">
                                        <input type="hidden" name="server_id" value="<?php echo $server->server_id; ?>">
                                        <input class="btn btn-danger" type="submit" value="Supprimer">
                                    </form>
                                </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Ajouter des serveurs
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="<?php echo site_url("admin/create_server"); ?>" method="post">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Nom</label>
                        <div class="col-md-9">
                            <input class=" form-control" name="server_name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Adresse</label>
                        <div class="col-md-9">
                            <input class=" form-control" name="server_host" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Port</label>
                        <div class="col-md-9">
                            <input class=" form-control" name="server_port" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Mot de passe</label>
                        <div class="col-md-9">
                            <input class=" form-control" name="server_password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="submit" class="btn btn-info" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>