<h2>Description de l'offre "<?php echo $offer->offer_name; ?>"</h2>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Caractéristiques</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="">
                    <label class="control-label">Description:</label><br />
                    <textarea class="form-control" rows="5" cols="55" name="offer_description"><?php echo $offer->offer_description; ?></textarea><br />
                    <input type="hidden" name="offer_id" value="<?php echo $offer->offer_id; ?>"><input class="btn btn-default" type="submit" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Ajouter un élément</h3>
            </div>
            <div class="panel-body">
                <form method="post" class="form-horizontal" action="<?php echo site_url("admin/create_element/" . $offer->offer_id); ?>">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Type d'élément</label>
                        <div class="col-md-9">
                            <select name="element_type" class="form-control">
                                <?php foreach($allTypesElement AS $elementTypeId => $elementType) { ?>
                                    <option value="<?php echo $elementTypeId; ?>"><?php echo $elementType["class"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Arguments</label>
                        <div class="col-md-9">
                            <input class="form-control" name="element_args">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <input type="hidden" name="offer_id" value="<?php echo $offer->offer_id; ?>"><button type="submit" class="btn btn-default">Valider</button>
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
                <h3 class="panel-title">Liste d'éléments</h3>
            </div>
            <div class="panel-body">
                <table class="table table-stripped table-bordered table-condensed table-centered">
                    <tr>
                        <th>Type</th>
                        <th>Args</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach ($allElements AS $element) { ?>
                        <tr>
                            <form action="<?php echo site_url("admin/update_element/" . $element->getId()); ?>" method="POST">
                                <td>
                                    <select class="form-control" name="element_type">
                                        <?php foreach($allTypesElement AS $elementTypeId => $elementType) { ?>
                                            <option <?php if ($element->getTypeId() == $elementTypeId) {?>selected<?php } ?> value="<?php echo $elementTypeId; ?>"><?php echo $elementType["class"]; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><input class="form-control" name="element_args" value="<?php echo implode(";", $element->getData()); ?>"></td>
                                <td><button class="btn btn-default" type="submit">Modifier</button></td>
                            </form>
                            <td>
                                <form method="post" onSubmit="return (confirm('Êtes vous-sur de vouloir supprimer cette élément ?'))" action="<?php echo site_url("admin/delete_element/" . $offer->offer_id); ?>">
                                    <input type="hidden" name="element_id" value="<?php echo $element->getId(); ?>">
                                    <button class="btn btn-danger" type="submit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>