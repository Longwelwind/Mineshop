<h2>Gestion des utilisateurs </h2>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Recherche</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" class="form-inline">
                    <div class="form-group col-md-8">
                        <div class="">
                            <input class="form-control" name="searchName">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="submit" class="btn btn-default" value="Rechercher" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Liste des utilisateurs (30)</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-stripped table-condensed table-centered">
                    <tr>
                        <th>Nom</th>
                        <th width="65px">Tokens</th>
                        <th>Email</th>
                        <th>Ancienneté</th>
                        <th>Admin</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach ($usersList as $user) { ?>
                    <tr <?php if ($user->user_is_admin) { ?>class="warning"<?php }  ?>>
                            <form action="<?php echo site_url("admin/user_update/" . $user->user_id); ?>" method="POST">
                                <td><input name="user_name" class="form-control" value="<?php echo htmlspecialchars($user->user_name); ?>"></td>
                                <td><input name="user_count_tokens" class="form-control" value="<?php echo $user->user_count_tokens; ?>"></td>
                                <td><input name="user_email" class="form-control" value="<?php echo htmlspecialchars($user->user_email); ?>"></td>
                                <td><input name="user_register_time" class="form-control" value="<?php echo $user->user_register_time; ?>"></td>
                                <td><input name="user_is_admin" type="checkbox" <?php if ($user->user_is_admin) { ?>checked="checked"<?php }  ?>></td>
                                <td><input class="btn btn-default" type="submit" value="Modifier"></td>
                                <td><a class="btn btn-info" href="<?php echo site_url("user/profile/" . $user->user_name); ?>">Profil</a></td>
                            </form>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>