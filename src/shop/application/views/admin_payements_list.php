<h2>Gestion des paiements</h2>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Ajouter une offre</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="<?php echo site_url("admin/create_payement/"); ?>" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-lg-3">Nom:</label>
                        <div class="col-lg-9">
                            <input name="payement_name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Type:</label>
                        <div class="col-lg-9">
                            <select class="form-control" name="payement_type">
                                <?php foreach($payementTypes AS $typeId => $type) { ?>
                                    <option value="<?php echo $typeId; ?>"><?php echo $type["class"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Args:</label>
                        <div class="col-lg-9">
                            <input name="payement_args" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Tokens donnés:</label>
                        <div class="col-lg-9">
                            <input name="payement_token_reward" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <input type="submit" class="btn btn-default">
                        </div>
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
                <h3 class="panel-title">Offres de paiements</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-stripped table-condensed">
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Args</th>
                        <th>Tokens donnés</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach ($payementsList AS $payement) { ?>
                        <tr>
                            <form name="payement_update" action="<?php echo site_url("admin/update_payement/" . $payement->payement_id); ?>" method="POST">
                                <td><input class="form-control" name="payement_name" value="<?php echo $payement->payement_name; ?>"></td>
                                <td>
                                  <select name="payement_type" class="form-control">
                                    <?php foreach($payementTypes AS $typeId => $type) { ?>
                                      <option <?php if ($payement->payement_type == $typeId) {?>selected<?php } ?> value="<?php echo $typeId; ?>"><?php echo $type["class"]; ?></option>
                                    <?php } ?>
                                  </select>
                                </td>
                                <td><input class="form-control" name="payement_args" value="<?php echo $payement->payement_args; ?>"></td>
                                <td><input class="form-control" name="payement_token_reward" style="width: 60px;" value="<?php echo $payement->payement_token_reward; ?>"> </td>
                            
                                <td align="center"><input class="btn btn-default" type="submit"></td>
                            </form>
                                <td align="center">
                                    <form method="post" onSubmit="return (confirm('Êtes vous-sur de vouloir supprimer ce payement ?'))" action="<?php echo site_url("admin/delete_payement/"); ?>">
                                        <input type="hidden" name="payement_id" value="<?php echo $payement->payement_id; ?>">
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